<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Office;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

class MigrateUserProfileDataToOffice extends Command
{
    protected $signature = 'migrate:profile-data-to-office';

    protected $description = 'Migrate office-related data from user_profiles to offices table';

    public function handle()
    {
        $this->info('Starting migration of user profile data to office table...');

        $this->ensureOfficeColumnsExist();

        $fieldsToMigrate = [
            'contact_number',
        ];

        $users = User::with(['profile', 'currentOffice'])
            ->whereHas('profile')
            ->whereHas('currentOffice')
            ->get();

        $this->info('Found ' . $users->count() . ' users with profile data and current office assignment.');

        $officeDataMap = [];

        foreach ($users as $user) {
            $officeId = $user->currentOffice->id;

            if (!$user->profile || !$officeId) {
                continue;
            }

            foreach ($fieldsToMigrate as $field) {
                if (!isset($user->profile->$field) || empty($user->profile->$field)) {
                    continue;
                }

                if (!isset($officeDataMap[$officeId])) {
                    $officeDataMap[$officeId] = [];
                }

                if (!isset($officeDataMap[$officeId][$field])) {
                    $officeDataMap[$officeId][$field] = $user->profile->$field;
                }
            }
        }

        $this->info('Collected data for ' . count($officeDataMap) . ' offices.');

        $updatedOffices = 0;
        foreach ($officeDataMap as $officeId => $data) {
            $office = Office::find($officeId);
            if (!$office) {
                continue;
            }

            $updateData = [];
            foreach ($data as $field => $value) {
                if (empty($office->$field)) {
                    $updateData[$field] = $value;
                }
            }

            if (!empty($updateData)) {
                $office->update($updateData);
                $updatedOffices++;
            }
        }

        $this->info("Successfully updated $updatedOffices offices with user profile data.");

        return Command::SUCCESS;
    }

    private function ensureOfficeColumnsExist()
    {
        $requiredColumns = [
            'contact_number',
        ];

        $this->info('Checking if required columns exist in offices table...');

        try {
            $columns = Schema::getColumnListing('offices');
        } catch (\Exception $e) {
            if (stripos($e->getMessage(), 'generation_expression') !== false) {
                $this->warn('Detected older MySQL version without generation_expression support. Falling back to SHOW COLUMNS.');
                $columns = collect(DB::select('SHOW COLUMNS FROM `offices`'))->pluck('Field')->toArray();
            } else {
                throw $e;
            }
        }

        $missingColumns = array_diff($requiredColumns, $columns);

        if (!empty($missingColumns)) {
            $this->warn('The following columns are missing from the offices table:');
            $this->line(implode(', ', $missingColumns));

            if ($this->confirm('Would you like to create these columns now?')) {
                Schema::table('offices', function (Blueprint $table) use ($missingColumns) {
                    foreach ($missingColumns as $column) {
                        $table->string($column)->nullable();
                    }
                });
                $this->info('Successfully added missing columns to offices table.');
            } else {
                $this->error('Required columns are missing. Please add them manually before running this command again.');
                return Command::FAILURE;
            }
        } else {
            $this->info('All required columns exist in the offices table.');
        }
    }
}
