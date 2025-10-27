<?php

class pluginLinuxCommandShowcase extends Plugin {

    public function init()
    {
        $this->dbFields = array(
            'showOnLoad' => true,
            'autoHideDelay' => 0,
            'categories' => 'file-management,system-info,networking,text-processing,user-management,process-management'
        );
    }

    public function form()
    {
        global $L;
        
        $html = '<div>';
        $html .= '<label>'.$L->get('Show popup on page load').'</label>';
        $html .= '<select name="showOnLoad">';
        $html .= '<option value="true" '.($this->getValue('showOnLoad')==='true'?'selected':'').'>Enabled</option>';
        $html .= '<option value="false" '.($this->getValue('showOnLoad')==='false'?'selected':'').'>Disabled</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>'.$L->get('Auto-hide delay (seconds, 0 = never)').'</label>';
        $html .= '<input name="autoHideDelay" type="number" value="'.$this->getValue('autoHideDelay').'">';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>'.$L->get('Active categories (comma-separated)').'</label>';
        $html .= '<input name="categories" type="text" value="'.$this->getValue('categories').'">';
        $html .= '<span class="tip">Available: file-management, system-info, networking, text-processing, user-management, process-management</span>';
        $html .= '</div>';

        return $html;
    }

    public function siteBodyEnd()
    {
        $pluginPath = $this->phpPath();
        $commandsPath = $pluginPath . 'commands/';
        
        // Load all commands from enabled categories
        $categories = explode(',', $this->getValue('categories'));
        $allCommands = array();
        
        foreach ($categories as $category) {
            $category = trim($category);
            $filePath = $commandsPath . $category . '.json';
            
            if (file_exists($filePath)) {
                $json = file_get_contents($filePath);
                $commands = json_decode($json, true);
                
                if ($commands && isset($commands['commands'])) {
                    foreach ($commands['commands'] as $cmd) {
                        $allCommands[] = $cmd;
                    }
                }
            }
        }

        if (empty($allCommands)) {
            return;
        }

        // Output CSS
        echo '<link rel="stylesheet" href="' . $this->htmlPath() . 'css/style.css">';
        
        // Output HTML
        echo '
        <div id="linux-cmd-popup" class="linux-cmd-hidden">
            <div class="linux-cmd-header">
                <span class="linux-cmd-title">Linux Command</span>
                <button class="linux-cmd-close" onclick="linuxCmdClose()">&times;</button>
            </div>
            <div class="linux-cmd-content">
                <div class="linux-cmd-command" id="linux-cmd-name"></div>
                <div class="linux-cmd-category" id="linux-cmd-category"></div>
                <div class="linux-cmd-description" id="linux-cmd-description"></div>
                <div class="linux-cmd-example-label">Example:</div>
                <div class="linux-cmd-example" id="linux-cmd-example"></div>
                <div class="linux-cmd-usecase" id="linux-cmd-usecase"></div>
                <div class="linux-cmd-meta" id="linux-cmd-meta"></div>
                <a class="linux-cmd-manpage" id="linux-cmd-manpage" href="#" target="_blank">View Man Page</a>
            </div>
        </div>
        ';

        // Output JavaScript
        echo '<script>';
        echo 'var linuxCommands = ' . json_encode($allCommands) . ';';
        echo 'var linuxCmdShowOnLoad = ' . ($this->getValue('showOnLoad') ? 'true' : 'false') . ';';
        echo 'var linuxCmdAutoHide = ' . intval($this->getValue('autoHideDelay')) . ';';
        echo '</script>';
        echo '<script src="' . $this->htmlPath() . 'js/script.js"></script>';
    }
}
?>
