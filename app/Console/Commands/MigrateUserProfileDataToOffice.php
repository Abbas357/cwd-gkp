<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Office;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MigrateUserProfileDataToOffice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:profile-data-to-office';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate office-related data from user_profiles to offices table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting migration of user profile data to office table...');

        // Ensure the required columns exist in the offices table
        $this->ensureOfficeColumnsExist();

        // Fields to migrate
        $fieldsToMigrate = [
            'landline_number',
            'facebook',
            'twitter'
        ];

        // Get all active users with profile data
        $users = User::with(['profile', 'currentOffice'])
            ->whereHas('profile')
            ->whereHas('currentOffice')
            ->get();

        $this->info('Found ' . $users->count() . ' users with profile data and current office assignment.');

        $officeDataMap = [];

        // Process each user and collect data for their respective offices
        foreach ($users as $user) {
            $officeId = $user->currentOffice->id;
            
            // Skip if we don't have profile or current office
            if (!$user->profile || !$officeId) {
                continue;
            }

            // For each field to migrate
            foreach ($fieldsToMigrate as $field) {
                // Skip if the user profile doesn't have this field or it's empty
                if (!isset($user->profile->$field) || empty($user->profile->$field)) {
                    continue;
                }

                // Initialize the office map entry if it doesn't exist
                if (!isset($officeDataMap[$officeId])) {
                    $officeDataMap[$officeId] = [];
                }

                // Only add data to the map if it's not already set
                // (This preserves the first user's data in case multiple users have data for the same office)
                if (!isset($officeDataMap[$officeId][$field])) {
                    $officeDataMap[$officeId][$field] = $user->profile->$field;
                }
            }
        }

        $this->info('Collected data for ' . count($officeDataMap) . ' offices.');

        // Update each office with the collected data
        $updatedOffices = 0;
        foreach ($officeDataMap as $officeId => $data) {
            $office = Office::find($officeId);
            if (!$office) {
                continue;
            }

            // Only update fields that aren't already populated
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

    /**
     * Ensure that the offices table has the required columns
     */
    private function ensureOfficeColumnsExist()
    {
        $requiredColumns = [
            'landline_number',
            'facebook',
            'twitter'
        ];

        $this->info('Checking if required columns exist in offices table...');
        
        $schema = Schema::getColumnListing('offices');
        $missingColumns = array_diff($requiredColumns, $schema);
        
        if (!empty($missingColumns)) {
            $this->warn('The following columns are missing from the offices table:');
            $this->line(implode(', ', $missingColumns));
            
            if ($this->confirm('Would you like to create these columns now?')) {
                Schema::table('offices', function ($table) use ($missingColumns) {
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