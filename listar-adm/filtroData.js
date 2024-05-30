function filtrarPorData() {
        
    const filtroData = document.getElementById('filtroData').value.toLowerCase();
    const linhas = document.querySelectorAll('.box tbody tr');
    
    linhas.forEach(linha => {
        
        const data = linha.querySelector('td:nth-child(7)').textContent.toLowerCase();
        
        if (data.includes(filtroData)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
        
    })
    
}