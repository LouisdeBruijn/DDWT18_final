
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function materialize() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Creates a focused label based on the form-values
(function focus_label(element_id) {
    // Get the variable
    var input = document.getElementById('element_id');
    // Return the statements
    if (input.value) {
        return 'floating-label has-value';
    } else {
        return 'floating-label';
    }
})();