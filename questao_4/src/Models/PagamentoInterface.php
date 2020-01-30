<?php

namespace Wjjunior\PassagemAerea\Models;

interface PagamentoInterface
{
    public function getVooIda(): Voo;
    public function setVooIda(Voo $vooIda): Pagamento;
    public function getVooVolta(): Voo;
    public function setVooVolta(Voo $vooVolta): Pagamento;
}
