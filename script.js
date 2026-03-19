function selectProduct(event, productId) {
    event.preventDefault();
    
    fetch('get_product.php?id=' + productId)
        .then(response => response.json())
        .then(data => {
            document.querySelector('#selected-product-container .name').textContent = data.name;
            document.querySelector('#selected-product-container img').src = data.image;
            document.querySelector('#selected-product-container img').alt = data.name;
            document.querySelector('#selected-product-container .main-price').textContent = data.main_price + ' ₽';
            document.querySelector('#selected-product-container .old-price').textContent = data.old_price + ' ₽';
            document.querySelector('#selected-product-container .discount').textContent = '-' + data.discount + '%';
            document.querySelector('#selected-product-container .description').textContent = data.description;
            
            document.getElementById('selected-product-id').value = data.id;
            document.getElementById('selected-product-price').value = data.main_price;
            document.getElementById('form-product-id').value = data.id;
            
            updateTotalPrice();
        })
        .catch(error => console.error('Error:', error));
}


function updateTotalPrice() {
    const quantity = document.getElementById('count-product').value;
    const price = document.getElementById('selected-product-price').value;
    const total = quantity * price;
    document.getElementById('total').value = total + ' ₽';
}

document.getElementById('count-product').addEventListener('change', updateTotalPrice);