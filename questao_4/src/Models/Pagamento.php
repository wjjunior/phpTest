<?php

namespace Wjjunior\PassagemAerea\Models;

use Wjjunior\Estacionamento\Models\PagamentoInterface;

class Pagamento implements PagamentoInterface
{

    private $vooIda;
    private $vooVolta;

    public function __construct(Voo $vooIda, Voo $vooVolta)
    {
        $this->vooIda = $vooIda;
        $this->vooVolta = $vooVolta;
    }

    /**
     * Get the value of vooIda
     */
    public function getVooIda(): Voo
    {
        return $this->vooIda;
    }

    /**
     * Set the value of vooIda
     *
     * @return  self
     */
    public function setVooIda(Voo $vooIda): Pagamento
    {
        $this->vooIda = $vooIda;

        return $this;
    }

    /**
     * Get the value of vooVolta
     */
    public function getVooVolta(): Voo
    {
        return $this->vooVolta;
    }

    /**
     * Set the value of vooVolta
     *
     * @return  self
     */
    public function setVooVolta(Voo $vooVolta): Pagamento
    {
        $this->vooVolta = $vooVolta;

        return $this;
    }
}
