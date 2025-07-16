<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    protected $locationData;

    public function __construct()
    {
        $this->locationData = include public_path('wilaya_balida.php');
        // Ensure we have an array of data
        if (!is_array($this->locationData)) {
            $this->locationData = [];
        }
    }

    public function getWilayas()
    {
        try {
            $wilayas = [];
            
            // Extract unique wilayas
            foreach ($this->locationData as $item) {
                if (isset($item['wilaya_name_ascii']) && $item['wilaya_name_ascii']) {
                    $wilayas[$item['wilaya_name_ascii']] = true;
                }
            }
            
            // Sort alphabetically
            $wilayas = array_keys($wilayas);
            sort($wilayas);
            
            return response()->json($wilayas);
            
        } catch (\Exception $e) {
            Log::error('Error in getWilayas: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load wilayas: ' . $e->getMessage()], 500);
        }
    }

    public function getBaladias($wilaya)
    {
        try {
            $baladias = [];
            
            foreach ($this->locationData as $item) {
                if (isset($item['wilaya_name_ascii']) && 
                    $item['wilaya_name_ascii'] === $wilaya &&
                    !empty($item['commune_name_ascii'])) {
                    $baladias[$item['commune_name_ascii']] = true;
                }
            }
            
            // Sort alphabetically
            $baladias = array_keys($baladias);
            sort($baladias);
            
            return response()->json($baladias);
            
        } catch (\Exception $e) {
            Log::error('Error in getBaladias: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load baladias: ' . $e->getMessage()], 500);
        }
    }

    public function getDairas($wilaya, $baladia)
    {
        try {
            $dairas = [];
            
            // First, find the daira_name_ascii for the selected baladia
            $dairaName = null;
            foreach ($this->locationData as $item) {
                if (isset($item['wilaya_name_ascii']) && 
                    $item['wilaya_name_ascii'] === $wilaya &&
                    isset($item['commune_name_ascii']) &&
                    $item['commune_name_ascii'] === $baladia &&
                    !empty($item['daira_name_ascii'])) {
                    $dairaName = $item['daira_name_ascii'];
                    break;
                }
            }
            
            if (!$dairaName) {
                return response()->json([]);
            }
            
            // Now find all communes that belong to this daira
            $communesInDaira = [];
            foreach ($this->locationData as $item) {
                if (isset($item['wilaya_name_ascii']) && 
                    $item['wilaya_name_ascii'] === $wilaya &&
                    isset($item['daira_name_ascii']) &&
                    $item['daira_name_ascii'] === $dairaName) {
                    if (!empty($item['commune_name_ascii'])) {
                        $communesInDaira[] = $item['commune_name_ascii'];
                    }
                }
            }
            
            // Return unique and sorted list of communes in the daira
            $communesInDaira = array_unique($communesInDaira);
            sort($communesInDaira);
            
            return response()->json($communesInDaira);
            
        } catch (\Exception $e) {
            Log::error('Error in getDairas: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load dairas: ' . $e->getMessage()], 500);
        }
    }
}
