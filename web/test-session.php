<?php
// Function to decode session data
function sessionDecode($session_data) {
    $return_data = [];
    $offset = 0;
    while ($offset < strlen($session_data)) {
        if (!strstr(substr($session_data, $offset), "|")) {
            return false;
        }
        $pos = strpos($session_data, "|", $offset);
        $num = $pos - $offset;
        $varname = substr($session_data, $offset, $num);
        $offset += $num + 1;
        $data = unserialize(substr($session_data, $offset));
        $return_data[$varname] = $data;
        $offset += strlen(serialize($data));
    }
    return $return_data;
}

// Get the path to the session directory
$sessionPath = ini_get('session.save_path');

// Define session timeout in seconds (e.g., 30 minutes)
$sessionTimeout = 30 * 60;

// Check if the directory exists
if ($sessionPath && is_dir($sessionPath)) {
    // Open the session directory
    if ($handle = opendir($sessionPath)) {
        // Initialize an array to hold session details
        $sessions = [];
        
        // Get the current time
        $currentTime = time();
        
        // Loop through the files in the session directory
        while (false !== ($file = readdir($handle))) {
            // Skip '.' and '..' directories
            if ($file != '.' && $file != '..') {
                // Get the full path of the session file
                $filePath = "$sessionPath/$file";
                // Check if the session file is recently modified
                if ($currentTime - filemtime($filePath) <= $sessionTimeout) {
                    // Extract the session ID from the file name
                    $sessionId = str_replace('sess_', '', $file);
                    // Read the session file
                    $sessionData = file_get_contents($filePath);
                    // Decode the session data
                    $session = sessionDecode($sessionData);
                    if ($session !== false) {
                        // Check if 'id', 'whsCode', or 'fname' are set in the session
                        if (isset($session['id'])) {
                            $id = $session['id'];
                            if (!isset($sessions[$id])) {
                                $sessions[$id] = [
                                    'id' => $id,
                                    'sessions' => []
                                ];
                            }
                            $sessionInfo = ['session_id' => $sessionId];
                            if (isset($session['whsCode'])) {
                                $sessionInfo['whsCode'] = $session['whsCode'];
                            }
                            if (isset($session['name'])) {
                                $sessionInfo['name'] = $session['name'];
                            }
                            $sessions[$id]['sessions'][] = $sessionInfo;
                        }
                    }
                }
            }
        }
        
        // Close the directory handle
        closedir($handle);
        
        // Prepare the response array
        $response = [
            'sessions' => array_values($sessions),
            'total_sessions' => count($sessions)
        ];

        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Prepare the error response
        $response = [
            'error' => 'Failed to open session directory.'
        ];

        // Output the error response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // Prepare the error response
    $response = [
        'error' => 'Session directory not found.'
    ];

    // Output the error response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
