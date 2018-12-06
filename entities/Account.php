<?php

declare (strict_types = 1);

class Account
{

    protected $id,
        $name,
        $balance;

    /**
     * constructor
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->hydrate($array);
    }

    /**
     * Hydratation
     *
     * @param array $donnees
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            // We retrieve the name of the setter corresponding to the attribute.
            $method = 'set' . ucfirst($key);
                
            // If the corresponding setter exists.
            if (method_exists($this, $method)) {
                // We call the setter.
                $this->$method($value);
            }
        }
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $id = (int)$id;
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of balance
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * Set the value of balance
     *
     * @return  self
     */
    public function setBalance($balance)
    {
        $balance = (int)$balance;
        $this->balance = $balance;

        return $this;
    }


    public function paymentBalance($amount)
    {
        $amount = (int)$amount;
        $this->balance += $amount;
    }

    public function withdrawalBalance($amount)
    {
        $amount = (int)$amount;

        if (($this->balance) < $amount) {
            echo 'Not enough money. ';

        } else {
            $this->balance -= $amount;
        }
    }
    public function sendBalance(Account $account, $balance)
    {
        if (($this->balance) < $balance) {
            echo 'Not enough money. ';

        } else {
            $balance = (int)$balance;
            $sendBalance = $account->getBalance() + $balance;
            $this->withdrawalBalance($balance);
            return $account->setBalance($sendBalance);
        }
    }

}
