// Select the profit element
const profitElement = document.querySelector('.profit-box');

// Function to update the profit value dynamically
function updateProfit(profit) {
    profitElement.innerHTML = `Profit Bulan Ini<br>Rp${profit.toLocaleString('id-ID')},00`;
}

// Example usage
const profitValue = 700000000;  // Change this value as needed
updateProfit(profitValue);