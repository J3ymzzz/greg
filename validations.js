const validation = new JustValidate("#signup");

validation
    .addField("#name", [
        {
            rule: "required",
            errorMessage: "Name is required" // Custom error message for the name field
        }
    ])
    .addField("#email", [
        {
            rule: "required",
            errorMessage: "Email is required" // Custom error message for the email field
        },
        {
            rule: "email",
            errorMessage: "Please enter a valid email" // Custom error message for invalid email format
        },
        {
            validator: (value) => {
                console.log("Checking email availability...");
                return fetch("validate-email.php?email=" + encodeURIComponent(value))
                    .then(function (response) {
                        console.log(response);
                        return response.json();
                    })
                    .then(function (json) {
                        console.log(json);
                        return json.available;
                    });
            },
            errorMessage: "Email is already taken" // Custom error message if email is taken
        }
    ])
    .addField("#password", [
        {
            rule: "required",
            errorMessage: "Password is required" // Custom error message for password field
        },
        {
            rule: "password",
            errorMessage: "Password must be at least 8 characters, contain one letter and one number" // Custom error message for password rules
        }
    ])
    .addField("#confirm-password", [
        {
            validator: (value, fields) => {
                return value === fields["#password"].elem.value;
            },
            errorMessage: "Passwords must match" // Custom error message for password mismatch
        }
    ])
    .onSuccess((event) => {
        // Prevent form submission if validation fails
        event.preventDefault();

        // Form submission happens only if all fields are valid
        console.log("Form validated successfully!");
        document.getElementById("signup").submit();
    })
    .onError(() => {
        console.log("Validation failed");
    });
