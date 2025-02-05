// Open Edit Product Modal
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        const modal = document.getElementById('editProductModal');
        const id = button.getAttribute('data-id');
        const name = button.getAttribute('data-name');
        const description = button.getAttribute('data-description');
        const price = button.getAttribute('data-price');
        const image = button.getAttribute('data-image');
        const isBestseller = button.getAttribute('data-bestseller');

        document.getElementById('editProductId').value = id;
        document.getElementById('editProductName').value = name;
        document.getElementById('editProductDescription').value = description;
        document.getElementById('editProductPrice').value = price;
        document.getElementById('editProductImage').value = image;
        document.getElementById('editProductBestseller').checked = isBestseller === '1';

        modal.style.display = 'flex';
    });
});

// Close Edit Product Modal
document.querySelector('.close').addEventListener('click', () => {
    document.getElementById('editProductModal').style.display = 'none';
});

// Close Modal when clicking outside
window.addEventListener('click', (e) => {
    const modal = document.getElementById('editProductModal');
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});