function doValidate() {
    console.log('Validating...');
    try {
        pw = document.getElementById('pass').value;
        em = document.getElementById('email').value;
        console.log("Validating pw="+pw+" em="+em);
        if (pw == null || pw == ""|| em == null || em == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if (em.indexOf('@') == -1){
            alert("Email address must contain @");
            return false;
        }
        return true;
    } catch(e) {
        alert(e);
        return false;
    }
}