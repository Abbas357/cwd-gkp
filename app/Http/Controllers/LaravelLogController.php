<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class LaravelLogController extends Controller
{
    protected $logPath;

    public function __construct()
    {
        $this->logPath = storage_path('logs');
        
        // Ensure the logs directory exists
        if (!File::exists($this->logPath)) {
            File::makeDirectory($this->logPath, 0755, true, true);
        }
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $filename = $request->input('file');
                $logs = $this->getLogs($filename);
                
                $dataTable = Datatables::of($logs)
                    ->addColumn('level', function ($row) {
                        return view('misc.laravel_logs.partials.level', ['level' => $row['level']])->render();
                    })
                    ->addColumn('message', function ($row) {
                        return view('misc.laravel_logs.partials.message', [
                            'message' => $row['message'],
                            'id' => $row['id']
                        ])->render();
                    })
                    ->addColumn('file', function ($row) {
                        return $row['file'] ?? 'N/A';
                    })
                    ->addColumn('line', function ($row) {
                        return $row['line'] ?? 'N/A';
                    })
                    ->addColumn('date', function ($row) {
                        try {
                            $date = Carbon::parse($row['date']);
                            return $date->format('j, F Y').' ('.$date->diffForHumans().')';
                        } catch (\Exception $e) {
                            return $row['date'] ?? 'Unknown';
                        }
                    })
                    ->addColumn('stack', function ($row) {
                        return view('misc.laravel_logs.partials.stack', [
                            'stack' => $row['stack'],
                            'id' => $row['id']
                        ])->render();
                    })
                    ->rawColumns(['level', 'message', 'stack']);

                return $dataTable->toJson();
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => 'Error processing log data: ' . $e->getMessage(),
                ], 500);
            }
        }

        try {
            // Get stats for dashboard
            $stats = $this->getLogStats();
        } catch (\Exception $e) {
            // In case of error, provide default stats with all expected fields
            $stats = [
                'total' => 0,
                'errors' => 0,
                'warnings' => 0,
                'info' => 0,
                'debug' => 0,
                'critical' => 0,
                'emergency' => 0, // Added to match view expectations
                'alert' => 0,
                'notice' => 0,
                'today' => 0,
                'latest' => null,
                'common_errors' => [],
                'error_trend' => $this->getEmptyTrendData()
            ];
        }

        return view('misc.laravel_logs.index', compact('stats'));
    }
    
    public function getLogFiles()
    {
        $files = File::files($this->logPath);
        $logFiles = [];
        
        foreach ($files as $file) {
            if (strpos($file->getFilename(), 'laravel') !== false) {
                $logFiles[] = [
                    'name' => $file->getFilename(),
                    'size' => $this->formatFileSize($file->getSize()),
                    'modified' => Carbon::parse($file->getMTime())->format('Y-m-d H:i:s'),
                ];
            }
        }
        
        return response()->json(['files' => $logFiles]);
    }
    
    public function downloadLog($filename)
    {
        $path = $this->logPath . '/' . $filename;
        
        if (File::exists($path)) {
            return response()->download($path);
        }
        
        return back()->with('error', 'Log file not found.');
    }
    
    public function deleteLog($filename)
    {
        $path = $this->logPath . '/' . $filename;
        
        if (File::exists($path)) {
            File::delete($path);
            return back()->with('success', 'Log file deleted successfully.');
        }
        
        return back()->with('error', 'Log file not found.');
    }
    
    public function clearLogs()
    {
        $files = File::files($this->logPath);
        
        foreach ($files as $file) {
            if (strpos($file->getFilename(), 'laravel') !== false) {
                File::delete($file->getPathname());
            }
        }
        
        return back()->with('success', 'All log files cleared successfully.');
    }

    protected function getLogs($filename = null)
    {
        if (!$filename) {
            // Look for the most recent log file
            $files = File::files($this->logPath);
            $logFiles = [];
            
            foreach ($files as $file) {
                if (strpos($file->getFilename(), 'laravel') !== false) {
                    $logFiles[] = $file;
                }
            }
            
            if (count($logFiles) > 0) {
                // Sort by modified time, newest first
                usort($logFiles, function($a, $b) {
                    return $b->getMTime() - $a->getMTime();
                });
                
                $filename = basename($logFiles[0]);
            } else {
                $filename = 'laravel-' . Carbon::now()->format('Y-m-d') . '.log';
            }
        }
        
        $path = $this->logPath . '/' . $filename;
        $logs = [];
        
        if (File::exists($path)) {
            try {
                $content = File::get($path);
                
                // Split the content by log entries - Laravel log format starts with [YYYY-MM-DD HH:MM:SS]
                $pattern = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/';
                $entries = preg_split($pattern, $content);
                
                // Get all dates from the log file
                preg_match_all('/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $content, $dates);
                
                // Remove the first empty entry
                if (!empty($entries[0]) && trim($entries[0]) === '') {
                    array_shift($entries);
                }
                
                // Loop through each entry and parse it
                foreach ($entries as $index => $entry) {
                    if (empty(trim($entry))) {
                        continue;
                    }
                    
                    $date = isset($dates[1][$index]) ? $dates[1][$index] : 'Unknown';
                    
                    // Parse log level (ERROR, INFO, WARNING, etc.)
                    preg_match('/^(\s+)?([A-Za-z]+)\.([A-Za-z]+):(.*)$/s', $entry, $levelMatch);
                    
                    $level = 'INFO'; // Default level
                    $fullMessage = $entry;
                    
                    if (!empty($levelMatch)) {
                        $level = strtoupper($levelMatch[3]);
                        $fullMessage = $levelMatch[4];
                    }
                    
                    // Extract stack trace if available
                    $stack = null;
                    $message = $fullMessage;
                    $file = null;
                    $line = null;
                    
                    // Check for stack trace
                    if (strpos($fullMessage, 'Stack trace:') !== false) {
                        $parts = explode('Stack trace:', $fullMessage, 2);
                        $message = trim($parts[0]);
                        $stack = trim($parts[1]);
                    }
                    
                    // Check for exception details
                    if (preg_match('/\[.*?\] ([^:]+)(?::|\.) (.+?) in (.+?):(\d+)/', $fullMessage, $exceptionMatches)) {
                        $message = trim($exceptionMatches[1] . ': ' . $exceptionMatches[2]);
                        $file = trim($exceptionMatches[3]);
                        $line = trim($exceptionMatches[4]);
                    } elseif (preg_match('/in (.+?):(\d+)/', $fullMessage, $fileMatches)) {
                        $file = trim($fileMatches[1]);
                        $line = trim($fileMatches[2]);
                    }
                    
                    // Try to parse JSON content if present
                    if (strpos($fullMessage, '{') !== false && strpos($fullMessage, '}') !== false) {
                        preg_match('/{.*}/s', $fullMessage, $jsonMatches);
                        
                        if (!empty($jsonMatches)) {
                            try {
                                $decoded = json_decode($jsonMatches[0], true);
                                
                                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                    if (isset($decoded['message'])) {
                                        $message = $decoded['message'];
                                    }
                                    
                                    if (isset($decoded['exception'])) {
                                        $stack = $decoded['exception'];
                                    }
                                    
                                    if (isset($decoded['file'])) {
                                        $file = $decoded['file'];
                                    }
                                    
                                    if (isset($decoded['line'])) {
                                        $line = $decoded['line'];
                                    }
                                }
                            } catch (\Exception $e) {
                                // If JSON parsing fails, use the original message
                            }
                        }
                    }
                    
                    $logs[] = [
                        'id' => $index,
                        'date' => $date,
                        'level' => $level,
                        'message' => $message,
                        'stack' => $stack,
                        'file' => $file,
                        'line' => $line,
                    ];
                }
            } catch (\Exception $e) {
                // If there's an error reading the log file, add an error entry
                $logs[] = [
                    'id' => 0,
                    'date' => Carbon::now()->format('Y-m-d H:i:s'),
                    'level' => 'ERROR',
                    'message' => 'Error parsing log file: ' . $e->getMessage(),
                    'stack' => $e->getTraceAsString(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];
            }
        } else {
            // If log file doesn't exist, add an info entry
            $logs[] = [
                'id' => 0,
                'date' => Carbon::now()->format('Y-m-d H:i:s'),
                'level' => 'INFO',
                'message' => 'No log file found at: ' . $path,
                'stack' => null,
                'file' => null,
                'line' => null,
            ];
        }
        
        return $logs;
    }
    
    protected function getLogStats()
    {
        $logs = $this->getLogs();
        $stats = [
            'total' => count($logs),
            'errors' => 0,
            'warnings' => 0,
            'info' => 0,
            'debug' => 0,
            'critical' => 0,
            'emergency' => 0, // Added to match view expectation
            'alert' => 0,
            'notice' => 0,
            'today' => 0,
            'latest' => null,
            'common_errors' => [], // To track most common error types
            'error_trend' => [],   // To track error frequency over time
        ];
        
        $today = Carbon::today();
        $errorMessages = [];
        $dateCounts = [];
        
        foreach ($logs as $log) {
            $logDate = Carbon::parse($log['date']);
            $dateKey = $logDate->format('Y-m-d');
            
            // Count logs by date for trend analysis
            if (!isset($dateCounts[$dateKey])) {
                $dateCounts[$dateKey] = [
                    'total' => 0,
                    'errors' => 0,
                    'warnings' => 0,
                    'info' => 0,
                    'other' => 0,
                ];
            }
            $dateCounts[$dateKey]['total']++;
            
            if ($logDate->isToday()) {
                $stats['today']++;
            }
            
            $level = strtolower($log['level']);
            switch ($level) {
                case 'error':
                    $stats['errors']++;
                    $dateCounts[$dateKey]['errors']++;
                    
                    // Track common errors (first 50 characters as key)
                    $errorKey = substr(trim($log['message']), 0, 50);
                    if (!isset($errorMessages[$errorKey])) {
                        $errorMessages[$errorKey] = 0;
                    }
                    $errorMessages[$errorKey]++;
                    break;
                case 'warning':
                    $stats['warnings']++;
                    $dateCounts[$dateKey]['warnings']++;
                    break;
                case 'info':
                    $stats['info']++;
                    $dateCounts[$dateKey]['info']++;
                    break;
                case 'debug':
                    $stats['debug']++;
                    $dateCounts[$dateKey]['other']++;
                    break;
                case 'critical':
                    $stats['critical']++;
                    $dateCounts[$dateKey]['errors']++;
                    break;
                case 'emergency':
                    $stats['emergency']++;
                    $dateCounts[$dateKey]['errors']++;
                    break;
                case 'alert':
                    $stats['alert']++;
                    $dateCounts[$dateKey]['errors']++;
                    break;
                case 'notice':
                    $stats['notice']++;
                    $dateCounts[$dateKey]['other']++;
                    break;
                default:
                    $dateCounts[$dateKey]['other']++;
            }
            
            if (!$stats['latest'] || $logDate->gt(Carbon::parse($stats['latest']))) {
                $stats['latest'] = $log['date'];
            }
        }
        
        // Get top 5 most common errors
        arsort($errorMessages);
        $stats['common_errors'] = array_slice($errorMessages, 0, 5, true);
        
        // Prepare error trend data (last 7 days)
        $stats['error_trend'] = $this->getTrendData($dateCounts);
        
        return $stats;
    }
    
    /**
     * Generate empty trend data structure for the last 7 days
     */
    protected function getEmptyTrendData()
    {
        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $last7Days[$date] = [
                'total' => 0,
                'errors' => 0,
                'warnings' => 0,
                'info' => 0,
                'other' => 0,
            ];
        }
        return $last7Days;
    }
    
    /**
     * Generate trend data for the last 7 days from collected date counts
     */
    protected function getTrendData($dateCounts)
    {
        $last7Days = $this->getEmptyTrendData();
        
        // Merge with actual data
        foreach ($last7Days as $date => &$defaultValues) {
            if (isset($dateCounts[$date])) {
                $defaultValues = $dateCounts[$date];
            }
        }
        
        return $last7Days;
    }
    
    protected function formatFileSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}