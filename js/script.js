function showNotification(message, type) {
    let notify = document.getElementById("notify");
    notify.className = "notify " + type;
    console.log(message);
    notify.innerText = message;
    notify.style.display = "block";

    // Visa notisen gradvis
    setTimeout(() => {
        notify.style.opacity = "1";
    }, 100);

    // Dölj efter 3 sekunder
    setTimeout(() => {
        notify.style.opacity = "0";
        setTimeout(() => {
            notify.style.display = "none";
        }, 500);
    }, 3000);
}
    function confirmDelete(filename) {
        if (confirm("Är du säker på att du vill ta bort " + filename + "?")) {
            fetch("delete.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "file=" + encodeURIComponent(filename)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "success") {
                    showNotification("Filen har raderats!", "success");
                    setTimeout(() => location.reload(), 1000); // Uppdatera sidan efter 1 sekund
                } else {
                    showNotification(data, "error");
                }
            })
            .catch(error => showNotification("Ett fel uppstod!", "error"));
        }
    }
    function toggleCategory(id) {
        var element = document.getElementById(id);
        if (element.style.display === "none" || element.style.display === "") {
            element.style.display = "block";
        } else {
            element.style.display = "none";
        }
    }
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            showNotification("Copied to clipboard!", "success");
        }).catch(err => {
            showNotification("Failed to copy!", "error");
        });
    }

    function insertAtCursor(input, text) {
        console.log("input");
        inputt = document.querySelector("textarea[name='markdown']");
        if (inputt.selectionStart || inputt.selectionStart === 0) {
            let startPos = inputt.selectionStart;
            let endPos = inputt.selectionEnd;
            inputt.value = inputt.value.substring(0, startPos) + text + inputt.value.substring(endPos, inputt.value.length);
        } else {
            inputt.value += text;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const subHeaders = document.querySelectorAll('.sub');
        subHeaders.forEach(header => {
            header.style.cursor = "pointer";
            let nextElem = header.nextElementSibling;
            let shouldExpand = false;
            const groupItems = [];
            
            // Samla in alla li-element under den aktuella .sub och kolla om någon är aktiv.
            while (nextElem && nextElem.tagName.toLowerCase() === "li") {
                groupItems.push(nextElem);
                if (nextElem.querySelector("a.active")) {
                    shouldExpand = true;
                }
                nextElem = nextElem.nextElementSibling;
            }
            
            // Om gruppen inte ska vara expanderad, dölj alla li-element. Annars, visa dem.
            groupItems.forEach(li => {
                li.style.display = shouldExpand ? "list-item" : "none";
            });
            
            // Om någon li hade en aktiv länk, sätt pilen i expanderat läge.
            if (shouldExpand) {
                header.classList.add("expanded");
            }
            
            // Klickhändelse för att toggla gruppens visning
            header.addEventListener("click", function() {
                header.classList.toggle("expanded");
                groupItems.forEach(li => {
                    li.style.display = (li.style.display === "none") ? "list-item" : "none";
                });
            });
        });
    });
    