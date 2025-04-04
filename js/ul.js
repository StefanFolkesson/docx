document.addEventListener("DOMContentLoaded", function () {
    let dropZone = document.getElementById("dropZone");
    let fileInput = document.getElementById("fileInput");
    let uploadStatus = document.getElementById("uploadStatus");

    dropZone.addEventListener("click", () => fileInput.click());

    dropZone.addEventListener("dragover", (event) => {
        event.preventDefault();
        dropZone.classList.add("hover");
    });

    dropZone.addEventListener("dragleave", () => {
        dropZone.classList.remove("hover");
    });

    dropZone.addEventListener("drop", (event) => {
        event.preventDefault();
        dropZone.classList.remove("hover");

        let files = event.dataTransfer.files;
        handleFiles(files);
    });

    fileInput.addEventListener("change", function () {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        for (let file of files) {
            let formData = new FormData();
            formData.append("file", file);
    
            let fileExt = file.name.split('.').pop().toLowerCase();
            let uploadURL = (fileExt === "md") ? "uploadfile.php" : "upload_image.php";
    
            let listItem = document.createElement("li");
            listItem.textContent = "Uploading: " + file.name;
            uploadStatus.appendChild(listItem);
    
            fetch(uploadURL, { method: "POST", body: formData })
                .then(response => response.text()) // Log response as text first
                .then(data => {
                    console.log("Server response:", data); // Debugging output
                    let jsonData;
                    try {
                        jsonData = JSON.parse(data); // Convert to JSON
                    } catch (error) {
                        listItem.textContent = "❌ Invalid server response.";
                        return;
                    }
    
                    if (jsonData.status === "success") {
                        listItem.textContent = "✅ " + jsonData.message;
    

                    } else {
                        listItem.textContent = "❌ " + jsonData.message;
                    }
                })
                .catch(error => {
                    console.error("Upload failed:", error);
                    listItem.textContent = "❌ Upload failed (JS error).";
                });
        }
    }
    
   function insertAtCursor(input, text) {
        if (input.selectionStart || input.selectionStart === 0) {
            let startPos = input.selectionStart;
            let endPos = input.selectionEnd;
            input.value = input.value.substring(0, startPos) + text + input.value.substring(endPos, input.value.length);
        } else {
            input.value += text;
        }
    }
});

// Add event listeners to the button uploadButton
document.getElementById("uploadButton").addEventListener("click", function () {
    // Skapa en fil med namnet som finns i inputten fileName och spara den på servern
    let fileName = document.getElementById("fileName").value;
    let fileContent = document.getElementById("fileContent").value;
    let formData = new FormData();
    formData.append("fileName", fileName);
    formData.append("fileContent", fileContent);
    formData.append("fileType", "md"); // Specify the file type
    let listItem = document.createElement("li");
    listItem.textContent = "Uploading: " + fileName;
    uploadStatus.appendChild(listItem);
    fetch("createfile.php", { method: "POST", body: formData })
        .then(response => response.text()) // Log response as text first
        .then(data => {
            console.log("Server response:", data); // Debugging output
            let jsonData;
            try {
                jsonData = JSON.parse(data); // Convert to JSON
            } catch (error) {
                listItem.textContent = "❌ Invalid server response.";
                return;
            }

            if (jsonData.status === "success") {
                listItem.textContent = "✅ " + jsonData.message;
            } else {
                listItem.textContent = "❌ " + jsonData.message;
            }
        })
        .catch(error => {
            console.error("Upload failed:", error);
            listItem.textContent = "❌ Upload failed (JS error).";
        });
    


/*    let blob = new Blob([fileContent], { type: "text/plain" });
    let link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = fileName;
    link.click();
    URL.revokeObjectURL(link.href); // Clean up the URL object
    link.remove(); // Remove the link element from the DOM
    alert("File " + fileName + " has been created and downloaded.");
    // Reset the input fields
    document.getElementById("fileName").value = "";
    document.getElementById("fileContent").value = "";
    */
});
