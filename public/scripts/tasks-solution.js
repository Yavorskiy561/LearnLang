document.querySelectorAll('.submit-form').forEach(form => {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const taskId = form.dataset.taskId;
        const resultDiv = form.parentElement.querySelector('.result');
        const resultText = resultDiv.querySelector('.result-text');
        
        try {
            const response = await fetch('/api/check-solution.php', {
                method: 'POST',
                body: JSON.stringify({
                    task_id: taskId,
                    code: formData.get('code')
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            
            const data = await response.json();
            
            resultDiv.style.display = 'block';
            resultText.parentElement.className = `alert alert-${data.success ? 'success' : 'danger'} fade show`;
            resultText.textContent = data.message;
            
        } catch (error) {
            resultDiv.style.display = 'block';
            resultText.parentElement.className = 'alert alert-danger fade show';
            resultText.textContent = 'Ошибка при проверке решения';
        }
    });
});
