const correctOldPassword = "ini123";

    $(document).ready(function() {
        $('#berikutnyaBtn').on('click', function() {
            const enteredPassword = $('#passLama').val();

            if (enteredPassword === correctOldPassword) {
                $('#passLama').removeClass('is-invalid');
                $('#passLama').addClass('is-valid');
                $('#notePassLama, #berikutnyaBtn').addClass('d-none');

                $('.inputFieldBaru, .inputFieldBaruConfirm, #simpanBtn').removeClass('d-none');
            } else {
                $('#passLama').addClass('is-invalid');
                $('#notePassLama').removeClass('d-none');
            }
        });

        $('#simpanBtn').on('click', function() {
            const newPassword = $('#passBaru').val();
            const confirmPassword = $('#passBaruConfirm').val();

            const hasUpperCase = /[A-Z]/.test(newPassword);
            const hasLowerCase = /[a-z]/.test(newPassword);
            const hasNumber = /[0-9]/.test(newPassword);
            const hasSpecialChar = /[!@#$%^&*]/.test(newPassword);
            const isValidLength = newPassword.length >= 8 && newPassword.length <= 25;

            $('#notePassBaruConfirm').addClass('d-none');
            $('#notePassBaruUpConfirm').addClass('d-none');
            $('#notePassBaruLowConfirm').addClass('d-none');
            $('#notePassBaruCharConfirm').addClass('d-none');
            $('#notePassBaruRangeConfirm').addClass('d-none');
            $('#notePassBaruAngkaConfirm').addClass('d-none');

            if (newPassword === confirmPassword && hasLowerCase && hasUpperCase && hasSpecialChar && isValidLength && hasNumber) {
                
                $('#passBaru, #passBaruConfirm').removeClass('is-invalid');
                $('#notePassBaruConfirm').addClass('d-none');
                $('#notePassBaruUpConfirm').addClass('d-none');
                $('#notePassBaruLowConfirm').addClass('d-none');
                $('#notePassBaruCharConfirm').addClass('d-none');
                $('#notePassBaruRangeConfirm').addClass('d-none');
                $('#notePassBaruAngkaConfirm').addClass('d-none');

                $('#confirmModal').modal('show');
                $('#gantiButton').on('click', function() {
                    $('#confirmModal').modal('hide');
                    $('#successModal').modal('show');
                    $('#confirmButton').on('click', function() {
                        $('#successModal').modal('hide');
                        window.location.href = 'profile.html';
                    });
                });
                $('#batalButton').on('click', function(){
                    $('#confirmModal').modal('hide');
                })

                
            } else if (newPassword != confirmPassword) {
                $('#passBaru, #passBaruConfirm').addClass('is-invalid');
                $('#notePassBaruConfirm').removeClass('d-none');
            } else if (!hasLowerCase) {
                $('#passBaru, #passBaruConfirm').addClass('is-invalid');
                $('#notePassBaruLowConfirm').removeClass('d-none');
            } else if (!hasUpperCase) {
                $('#passBaru, #passBaruConfirm').addClass('is-invalid');
                $('#notePassBaruUpConfirm').removeClass('d-none');
            } else if (!hasSpecialChar){
                $('#passBaru, #passBaruConfirm').addClass('is-invalid');
                $('#notePassBaruCharConfirm').removeClass('d-none');
            } else if (!isValidLength) {
                $('#passBaru, #passBaruConfirm').addClass('is-invalid');
                $('#notePassBaruRangeConfirm').removeClass('d-none');
            } else {
                $('#passBaru, #passBaruConfirm').addClass('is-invalid');
                $('#notePassBaruAngkaConfirm').removeClass('d-none');
            }
        });
    });