<?php

namespace Database\Seeders;
use Exception;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class DataCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        // path to the CSV file
        $path = storage_path('app/csv_file/Data.csv');

        // Open the CSV file and read its contents
        $file = fopen($path, 'r');
        
        // Skip the header row
        $header = fgetcsv($file);

        while (($data = fgetcsv($file)) !== FALSE) {

            // save data
            
            if($this->checkRows($data)){
                DB::table('news')->insert([
                    'end_year' => $data[0],
                        'citylng' => $data[1],
                        'citylat' => $data[2],
                        'intensity' => $data[3],
                        'sector' => $data[4],
                        'topic' => $data[5],
                        'insight' => $data[6],
                        'swot' => $data[7],
                        'url' => $data[8],
                        'region' => $data[9],
                        'start_year' => $data[10],
                        'impact' => $data[11],
                        'added' => $data[12],
                        'published' => $data[13],
                        'city' => $data[14],
                        'country' => $data[15],
                        'relevance' => $data[16],
                        'pestle' => $data[17],
                        'source' => $data[18],
                        'title' => $data[19],
                        'likelihood' => $data[20]
                ]);
            }
            
        }

        // Close the file
        fclose($file);

    }

    //validate each row data value
    private function checkRows($data){

        for($i =0; $i<count($data); $i++ ){
            
            if(preg_match('/[^a-zA-Z0-9]/', $data[6]) > 0 ){
                continue;
            }
        }
        
    }
}
