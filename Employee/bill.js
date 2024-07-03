
const itemDetails = {
    "001": {
        name: "Shirt",
        price: 20.00
    },
    "002": {
        name: "Pants",
        price: 30.00
    },
    "003": {
        name: "Shoes",
        price: 50.00
    }
};

let items = []; 


function populateItemDetails() {
    let itemId = document.getElementById("itemId").value;
    let item = itemDetails[itemId];
    if (item) {
        document.getElementById("itemName").value = item.name;
        document.getElementById("unitPrice").value = item.price.toFixed(2);
    } else {
        document.getElementById("itemName").value = "";
        document.getElementById("unitPrice").value = "";
    }
}


function addItem() {
    let itemId = document.getElementById("itemId").value;
    let itemName = document.getElementById("itemName").value;
    let quantity = document.getElementById("quantity").value;
    let unitPrice = parseFloat(document.getElementById("unitPrice").value);
    let total = quantity * unitPrice;

    let newItem = {
        itemId: itemId,
        itemName: itemName,
        quantity: parseInt(quantity),
        unitPrice: unitPrice,
        total: total
    };

    items.push(newItem);

    let tableBody = document.getElementById("checkoutTableBody");
    let newRow = `
        <tr>
            <td>${itemId}</td>
            <td>${itemName}</td>
            <td>${quantity}</td>
            <td>${unitPrice.toFixed(2)}</td>
            <td>${total.toFixed(2)}</td>
            <td><button class="btn btn-danger btn-sm" onclick="removeItem(${items.length - 1})"><i class="fas fa-trash-alt"></i></button></td>
        </tr>
    `;
    tableBody.innerHTML += newRow;

    updateGrandTotal(total);
}

function removeItem(index) {
    let removedItem = items.splice(index, 1)[0];
    let tableBody = document.getElementById("checkoutTableBody");
    tableBody.removeChild(tableBody.childNodes[index]);
    
    let total = removedItem.total;
    updateGrandTotal(-total);
}

function updateGrandTotal(amount) {
    let grandTotalElement = document.getElementById("grandTotal");
    let currentTotal = parseFloat(grandTotalElement.innerText);
    grandTotalElement.innerText = (currentTotal + amount).toFixed(2);
}

function submitBill() {
    alert("Bill Submitted Successfully!");
}

function backToHome() {
    alert("Navigating back to home!");
}

window.addEventListener('DOMContentLoaded', (event) => {
    const shopNameInput = document.getElementById('shopName');
    const shopInfo = document.getElementById('shopInfo');
    const currentDate = new Date().toLocaleDateString();

    shopNameInput.addEventListener('input', () => {
        const shopName = shopNameInput.value;
        shopInfo.innerText = `${shopName} - ${currentDate}`;
    });
});


