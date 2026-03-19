document.getElementById('order-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        first_name: document.getElementById('first_name').value,
        second_name: document.getElementById('second_name').value,
        third_name: document.getElementById('third_name').value,
        email: document.getElementById('email').value,
        address: document.getElementById('address').value,
        payment: document.querySelector('input[name="payment"]:checked').value,
        quantity: document.getElementById('count-product').value,
        total: document.getElementById('total').value.replace(/ ₽/, ''),
        product_id: document.getElementById('form-product-id').value
    };

    // Показываем лоадер
    document.getElementById('submit-order-ok').disabled = true;
    document.getElementById('submit-order-ok').textContent = 'Обработка...';

    fetch('process_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Заказ успешно оформлен!`);
        } else {
            alert('Ошибка: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Произошла ошибка при отправке формы');
    })
    .finally(() => {
        document.getElementById('submit-order-ok').disabled = false;
        document.getElementById('submit-order-ok').textContent = 'Купить';
    });
});