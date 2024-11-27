function validateInput(field) {
    var value = document.getElementById(field).value;
    var xhr = new XMLHttpRequest();
    
    xhr.open("POST", "validate.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Display the error message returned by PHP
            document.getElementById(field + "_error").innerHTML = xhr.responseText;
        }
    };

    // Send the field and its value for validation
    xhr.send("field=" + field + "&value=" + encodeURIComponent(value));
}
