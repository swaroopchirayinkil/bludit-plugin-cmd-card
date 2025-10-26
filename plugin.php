<?php

class pluginLinuxCommandPopup extends Plugin {
    
    public function init()
    {
        $this->dbFields = array(
            'displayDuration' => 10,
            'cookieExpiry' => 24,
            'popupPosition' => 'bottom-left'
        );
    }

    private function getLinuxCommands()
    {
        return array(
            array(
                'command' => 'ls',
                'description' => 'List directory contents',
                'category' => 'File Management',
                'skill_level' => 'Beginner',
                'use_case' => 'View files and directories in current location',
                'man_url' => 'https://man7.org/linux/man-pages/man1/ls.1.html'
            ),
            array(
                'command' => 'grep',
                'description' => 'Search text using patterns',
                'category' => 'Text Processing',
                'skill_level' => 'Intermediate',
                'use_case' => 'Find specific text within files or output',
                'man_url' => 'https://man7.org/linux/man-pages/man1/grep.1.html'
            ),
            array(
                'command' => 'chmod',
                'description' => 'Change file permissions',
                'category' => 'File Management',
                'skill_level' => 'Intermediate',
                'use_case' => 'Modify read, write, and execute permissions',
                'man_url' => 'https://man7.org/linux/man-pages/man1/chmod.1.html'
            ),
            array(
                'command' => 'ssh',
                'description' => 'Secure Shell remote login',
                'category' => 'Networking',
                'skill_level' => 'Intermediate',
                'use_case' => 'Connect securely to remote servers',
                'man_url' => 'https://man7.org/linux/man-pages/man1/ssh.1.html'
            ),
            array(
                'command' => 'top',
                'description' => 'Display system processes',
                'category' => 'System Monitoring',
                'skill_level' => 'Beginner',
                'use_case' => 'Monitor CPU and memory usage in real-time',
                'man_url' => 'https://man7.org/linux/man-pages/man1/top.1.html'
            ),
            array(
                'command' => 'awk',
                'description' => 'Pattern scanning and text processing',
                'category' => 'Text Processing',
                'skill_level' => 'Advanced',
                'use_case' => 'Extract and manipulate data from text files',
                'man_url' => 'https://man7.org/linux/man-pages/man1/awk.1p.html'
            ),
            array(
                'command' => 'sed',
                'description' => 'Stream editor for text transformation',
                'category' => 'Text Processing',
                'skill_level' => 'Advanced',
                'use_case' => 'Find and replace text, line filtering',
                'man_url' => 'https://man7.org/linux/man-pages/man1/sed.1.html'
            ),
            array(
                'command' => 'tar',
                'description' => 'Archive files',
                'category' => 'File Management',
                'skill_level' => 'Intermediate',
                'use_case' => 'Create and extract compressed archives',
                'man_url' => 'https://man7.org/linux/man-pages/man1/tar.1.html'
            ),
            array(
                'command' => 'find',
                'description' => 'Search for files in directory hierarchy',
                'category' => 'File Management',
                'skill_level' => 'Intermediate',
                'use_case' => 'Locate files by name, size, date, or permissions',
                'man_url' => 'https://man7.org/linux/man-pages/man1/find.1.html'
            ),
            array(
                'command' => 'ps',
                'description' => 'Report process status',
                'category' => 'System Monitoring',
                'skill_level' => 'Beginner',
                'use_case' => 'View currently running processes',
                'man_url' => 'https://man7.org/linux/man-pages/man1/ps.1.html'
            ),
            array(
                'command' => 'netstat',
                'description' => 'Network statistics',
                'category' => 'Networking',
                'skill_level' => 'Intermediate',
                'use_case' => 'Display network connections and routing tables',
                'man_url' => 'https://man7.org/linux/man-pages/man8/netstat.8.html'
            ),
            array(
                'command' => 'rsync',
                'description' => 'Remote file synchronization',
                'category' => 'File Management',
                'skill_level' => 'Advanced',
                'use_case' => 'Efficiently sync files between systems',
                'man_url' => 'https://man7.org/linux/man-pages/man1/rsync.1.html'
            ),
            array(
                'command' => 'df',
                'description' => 'Report disk space usage',
                'category' => 'System Monitoring',
                'skill_level' => 'Beginner',
                'use_case' => 'Check available disk space on filesystems',
                'man_url' => 'https://man7.org/linux/man-pages/man1/df.1.html'
            ),
            array(
                'command' => 'curl',
                'description' => 'Transfer data from or to a server',
                'category' => 'Networking',
                'skill_level' => 'Intermediate',
                'use_case' => 'Download files or test APIs',
                'man_url' => 'https://man7.org/linux/man-pages/man1/curl.1.html'
            ),
            array(
                'command' => 'systemctl',
                'description' => 'Control systemd services',
                'category' => 'System Administration',
                'skill_level' => 'Intermediate',
                'use_case' => 'Start, stop, and manage system services',
                'man_url' => 'https://man7.org/linux/man-pages/man1/systemctl.1.html'
            ),
            array(
                'command' => 'journalctl',
                'description' => 'Query systemd journal',
                'category' => 'System Monitoring',
                'skill_level' => 'Intermediate',
                'use_case' => 'View and analyze system logs',
                'man_url' => 'https://man7.org/linux/man-pages/man1/journalctl.1.html'
            ),
            array(
                'command' => 'iptables',
                'description' => 'Configure firewall rules',
                'category' => 'Networking',
                'skill_level' => 'Advanced',
                'use_case' => 'Set up network packet filtering and NAT',
                'man_url' => 'https://man7.org/linux/man-pages/man8/iptables.8.html'
            ),
            array(
                'command' => 'docker',
                'description' => 'Container management',
                'category' => 'Containerization',
                'skill_level' => 'Advanced',
                'use_case' => 'Build, run, and manage containers',
                'man_url' => 'https://docs.docker.com/engine/reference/commandline/docker/'
            ),
            array(
                'command' => 'vim',
                'description' => 'Powerful text editor',
                'category' => 'Text Processing',
                'skill_level' => 'Intermediate',
                'use_case' => 'Edit text files efficiently',
                'man_url' => 'https://man7.org/linux/man-pages/man1/vim.1.html'
            ),
            array(
                'command' => 'cron',
                'description' => 'Schedule recurring tasks',
                'category' => 'System Administration',
                'skill_level' => 'Intermediate',
                'use_case' => 'Automate script execution at specific times',
                'man_url' => 'https://man7.org/linux/man-pages/man8/cron.8.html'
            )
        );
    }

    public function siteBodyEnd()
    {
        $commands = $this->getLinuxCommands();
        $randomCommand = $commands[array_rand($commands)];
        
        $html = '
        <link rel="stylesheet" href="' . $this->htmlPath() . 'css/popup-style.css">
        <div id="linux-cmd-popup" class="linux-popup">
            <button id="close-popup" class="close-btn">&times;</button>
            <div class="popup-content">
                <h3 class="cmd-title">Linux Command</h3>
                <div class="cmd-name"><code>' . htmlspecialchars($randomCommand['command']) . '</code></div>
                <p class="cmd-description">' . htmlspecialchars($randomCommand['description']) . '</p>
                <div class="cmd-details">
                    <div class="detail-item">
                        <span class="detail-label">Category:</span>
                        <span class="detail-value">' . htmlspecialchars($randomCommand['category']) . '</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Skill Level:</span>
                        <span class="detail-value skill-' . strtolower($randomCommand['skill_level']) . '">' . htmlspecialchars($randomCommand['skill_level']) . '</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Use Case:</span>
                        <span class="detail-value">' . htmlspecialchars($randomCommand['use_case']) . '</span>
                    </div>
                </div>
                <a href="' . htmlspecialchars($randomCommand['man_url']) . '" target="_blank" class="man-link">View Man Page →</a>
            </div>
        </div>
        <script src="' . $this->htmlPath() . 'js/popup-script.js"></script>
        ';
        
        echo $html;
    }

    public function form()
    {
        $html = '
        <div>
            <label>Display Duration (seconds)</label>
            <input name="displayDuration" type="number" value="' . $this->getValue('displayDuration') . '">
            <span class="tip">How long to display the popup before auto-hiding</span>
        </div>
        <div>
            <label>Cookie Expiry (hours)</label>
            <input name="cookieExpiry" type="number" value="' . $this->getValue('cookieExpiry') . '">
            <span class="tip">How long before showing the popup again to the same visitor</span>
        </div>
        ';
        return $html;
    }
}
?>
