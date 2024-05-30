function filtrarPorNome() {

    const filtroNome = document.getElementById('filtroNome').value.toLowerCase();
    const linhas = document.querySelectorAll('.box tbody tr');

    linhas.forEach(linha => {

        const nome = linha.querySelector('td:nth-child(2)').textContent.toLowerCase();

        if (nome.includes(filtroNome)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
        
    });
}

