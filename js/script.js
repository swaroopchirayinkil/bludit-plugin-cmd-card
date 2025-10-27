var linuxCmdCurrentIndex = -1;
var linuxCmdClosed = false;

function linuxCmdGetRandom() {
    if (!linuxCommands || linuxCommands.length === 0) {
        return null;
    }
    
    var newIndex;
    do {
        newIndex = Math.floor(Math.random() * linuxCommands.length);
    } while (newIndex === linuxCmdCurrentIndex && linuxCommands.length > 1);
    
    linuxCmdCurrentIndex = newIndex;
    return linuxCommands[newIndex];
}

function linuxCmdDisplay(command) {
    if (!command) return;
    
    document.getElementById('linux-cmd-name').textContent = command.command;
    document.getElementById('linux-cmd-category').textContent = command.category || 'General';
    document.getElementById('linux-cmd-description').textContent = command.description;
    document.getElementById('linux-cmd-example').textContent = command.example;
    document.getElementById('linux-cmd-usecase').innerHTML = '<strong>Use Case:</strong> ' + command.usecase;
    
    var metaText = '';
    if (command.author) {
        metaText += '<strong>Author:</strong> ' + command.author;
    }
    if (command.developer) {
        metaText += (metaText ? ' | ' : '') + '<strong>Developer:</strong> ' + command.developer;
    }
    if (command.year) {
        metaText += (metaText ? '<br>' : '') + '<strong>Year:</strong> ' + command.year;
    }
    document.getElementById('linux-cmd-meta').innerHTML = metaText;
    
    var manUrl = command.manpage || 'https://man7.org/linux/man-pages/man1/' + command.command + '.1.html';
    document.getElementById('linux-cmd-manpage').href = manUrl;
    
    var popup = document.getElementById('linux-cmd-popup');
    popup.classList.remove('linux-cmd-hidden');
    
    if (linuxCmdAutoHide > 0) {
        setTimeout(function() {
            linuxCmdClose();
        }, linuxCmdAutoHide * 1000);
    }
}

function linuxCmdClose() {
    linuxCmdClosed = true;
    document.getElementById('linux-cmd-popup').classList.add('linux-cmd-hidden');
}

function linuxCmdShow() {
    var command = linuxCmdGetRandom();
    linuxCmdDisplay(command);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    if (linuxCmdShowOnLoad && !linuxCmdClosed) {
        setTimeout(function() {
            linuxCmdShow();
        }, 1000);
    }
});
