

var selectElement = document.getElementById('selectOption');
var selectElement1 = document.getElementById('selectOptions1');




selectElement.addEventListener('change', function() {
    var selectedOption = selectElement.value;
    
    if (selectedOption === 'Banks') {
        window.location.href = 'Banks.php';
    }else if (selectedOption === 'agency') {
        window.location.href = 'agency.php';
     }else if (selectedOption === 'ATM') {
        window.location.href = 'ATM.php';
    }
    });



    selectElement1.addEventListener('change', function() {
        var selectedOption = selectElement1.value;
        
        if (selectedOption === 'client') {
            window.location.href = 'users.php';
            } else if (selectedOption === 'accounts') {
            window.location.href = 'accounts.php';
            } else if (selectedOption === 'transactions') {
            window.location.href = 'transactions.php';
            }else if (selectedOption === 'clian') {
                window.location.href = 'clients.php';
                }
        });
