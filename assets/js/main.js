document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Filtro de busca dinâmica
    const filtroInput = document.getElementById('filtro');
    if (filtroInput) {
        filtroInput.addEventListener('keyup', function() {
            let termo = this.value.toLowerCase();
            let cards = document.querySelectorAll('.card-tarefa-wrapper');
            
            cards.forEach(card => {
                let titulo = card.querySelector('.card-title').innerText.toLowerCase();
                let descricao = card.querySelector('.card-text').innerText.toLowerCase();
                
                if (titulo.includes(termo) || descricao.includes(termo)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // 2. Confirmação de exclusão
    const botoesExcluir = document.querySelectorAll('.btn-outline-danger');
    botoesExcluir.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('Você tem certeza que deseja excluir esta tarefa? Esta ação não pode ser desfeita.')) {
                e.preventDefault();
            }
        });
    });

    // 3. Auto-fechar alertas de sucesso após 4 segundos
    const alertas = document.querySelectorAll('.alert');
    alertas.forEach(alerta => {
        setTimeout(() => {
            let bsAlert = new bootstrap.Alert(alerta);
            bsAlert.close();
        }, 4000);
    });
});