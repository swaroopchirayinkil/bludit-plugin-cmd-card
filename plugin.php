<?php

class pluginLinuxCommandsPopup extends Plugin {

    public function init()
    {
        $this->dbFields = array(
            'showOnce' => true,
            'popupDelay' => 1000,
            'enabledCategories' => 'all'
        );
    }

    private function loadAllCommands()
    {
        $commands = array();
        $dataPath = $this->phpPath() . 'data/';
        
        // Check if data directory exists
        if (!is_dir($dataPath)) {
            error_log('Linux Commands Popup: data directory not found');
            return $commands;
        }
        
        // Get all JSON files from data directory
        $jsonFiles = glob($dataPath . '*.json');
        
        if (empty($jsonFiles)) {
            error_log('Linux Commands Popup: No JSON files found in data directory');
            return $commands;
        }
        
        // Load and merge all command files
        foreach ($jsonFiles as $file) {
            $fileContent = file_get_contents($file);
            
            if ($fileContent === false) {
                error_log('Linux Commands Popup: Failed to read ' . basename($file));
                continue;
            }
            
            $jsonData = json_decode($fileContent, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log('Linux Commands Popup: JSON decode error in ' . basename($file) . ': ' . json_last_error_msg());
                continue;
            }
            
            if (is_array($jsonData)) {
                $commands = array_merge($commands, $jsonData);
            }
        }
        
        return $commands;
    }

    public function siteBodyEnd()
    {
        // Load all commands from multiple JSON files
        $commands = $this->loadAllCommands();
        
        if (empty($commands)) {
            error_log('Linux Commands Popup: No commands loaded');
            return;
        }
        
        // Select random command
        $randomCommand = $commands[array_rand($commands)];
        
        // Generate HTML
        $html = $this->getPopupHTML($randomCommand);
        
        // Load CSS
        $css = '<link rel="stylesheet" href="' . $this->htmlPath() . 'css/popup.css">';
        
        echo $css . $html;
    }

    private function getPopupHTML($command)
    {
        $name = htmlspecialchars($command['name']);
        $category = htmlspecialchars($command['category']);
        $description = htmlspecialchars($command['description']);
        $example = htmlspecialchars($command['example']);
        $useCase = htmlspecialchars($command['useCase']);
        $author = htmlspecialchars($command['author']);
        $manPageUrl = htmlspecialchars($command['manPageUrl']);
        
        return <<<HTML
        <div id="linuxCommandPopup" class="linux-popup-overlay">
            <div class="linux-popup-container">
                <div class="linux-popup-header">
                    <h2>Linux Command: {$name}</h2>
                    <button class="linux-popup-close" onclick="closeLinuxPopup()">&times;</button>
                </div>
                
                <div class="linux-popup-content">
                    <div class="command-section">
                        <span class="label">Category:</span>
                        <span class="value">{$category}</span>
                    </div>
                    
                    <div class="command-section">
                        <span class="label">Description:</span>
                        <p class="value">{$description}</p>
                    </div>
                    
                    <div class="command-section">
                        <span class="label">Example:</span>
                        <pre class="value"><code>{$example}</code></pre>
                    </div>
                    
                    <div class="command-section">
                        <span class="label">Use Case:</span>
                        <p class="value">{$useCase}</p>
                    </div>
                    
                    <div class="command-section">
                        <span class="label">Author/Developer:</span>
                        <span class="value">{$author}</span>
                    </div>
                    
                    <div class="command-section">
                        <a href="{$manPageUrl}" target="_blank" class="man-page-link">View Man Page →</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function closeLinuxPopup() {
            document.getElementById('linuxCommandPopup').style.display = 'none';
        }
        
        // Show popup after page load
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('linuxCommandPopup').style.display = 'flex';
            }, 500);
        });
        
        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLinuxPopup();
            }
        });
        </script>
HTML;
    }

    public function form()
    {
        $html = '<div>';
        $html .= '<label>Show popup once per session</label>';
        $html .= '<select name="showOnce">';
        $html .= '<option value="true" ' . ($this->getValue('showOnce') ? 'selected' : '') . '>Yes</option>';
        $html .= '<option value="false" ' . (!$this->getValue('showOnce') ? 'selected' : '') . '>No</option>';
        $html .= '</select>';
        $html .= '<p class="tip">Enable this to show popup only once per browser session</p>';
        $html .= '</div>';
        return $html;
    }
}
?>
