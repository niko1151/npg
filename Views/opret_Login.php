<!-- Formularen til oprettelse af login -->
<form id="info-input" method="post" action="<?= getenv('BASE_URL')?>/save_Login" onsubmit="return validatePassword();">

    <!-- Input-felter for brugeroplysninger -->
    <div class="form-group">
        <input required type="text" name="CreateFirstName" placeholder="indtast Fornavn" class="btn-lg btn-block mt-4">
    </div>
    <div class="form-group">
        <input required type="text" name="CreateLastName" placeholder="indtast EfterNavn" class="btn-lg btn-block mt-4">
    </div>
    <div class="form-group">
        <input required type="text" name="CreateEmail" placeholder="indtast Email" class="btn-lg btn-block mt-4">
    </div>
    <div class="form-group">
        <input required type="text" name="CreateTelefonNummer" placeholder="indtast Telefon Nr." class="btn-lg btn-block mt-4">
    </div>
    <div class="form-group">
        <input required type="password" name="CreatePassword" id="CreatePassword" placeholder="Indtast Password" class="btn-lg btn-block mt-4">
    </div>
    <div class="form-group">
        <input required type="password" name="ConfirmPassword" id="ConfirmPassword" placeholder="Bekræft Password" class="btn-lg btn-block mt-4">
        <span id="passwordError" style="color: red;"></span>
    </div>
    <div class="form-group">
        <input required type="text" name="CreateAdresse" placeholder="indtast Adresse" class="btn-lg btn-block mt-4">
    </div>
    <div class="form-group">
        <input required type="text" name="CreateByNavn" placeholder="indtast By" class="btn-lg btn-block mt-4">
    </div>
    <div class="form-group">
        <input required type="text" name="CreatePostNummer" placeholder="indtast Postnummer" class="btn-lg btn-block mt-4">
    </div>

    <br>

    <!-- Knapper til at sende eller annullere oprettelsesprocessen -->
    <div class="form-group">
        <input type="submit" class="btn btn-success" value="Send">
        <a class="btn btn-danger" href="<?= getenv('BASE_URL')?>">Cancel</a>
    </div>
</form>

<!-- JavaScript til validering af adgangskoder -->
<script>
    function validatePassword() {
        var password = document.getElementById("CreatePassword").value;
        var confirmPassword = document.getElementById("ConfirmPassword").value;
        var errorSpan = document.getElementById("passwordError");

        // Valider, om adgangskoderne stemmer overens
        if (password !== confirmPassword) {
            errorSpan.textContent = "Adgangskoderne stemmer ikke overens!";
            return false; // Forhindrer formularafsendelse
        } else {
            errorSpan.textContent = ""; // Ryd fejlmeddelelse, hvis adgangskoderne er ens
            return true; // Tillader formularafsendelse
        }
    }
</script>
