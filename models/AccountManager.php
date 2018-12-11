<?php

declare (strict_types = 1);

class AccountManager
{

    private $db;

    /**
     * __construct function
     * @param PDO $db
     */
    public function __construct(PDO $db)

    {
        $this->setDb($db);
    }


    /**
     * Get the value of db
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * Set the value of db
     *
     * @return  self
     */
    public function setDb($db)
    {
        $this->db = $db;

        return $this;
    }

    /**
     * addAccount function
     * @param Accounts $accounts
     */
    public function addAccount(Account $account)
    {

        $query = $this->getDb()->prepare('INSERT INTO accounts (name, balance) VALUES (:name, :balance)');
        $query->bindValue('name', $account->getName(), PDO::PARAM_STR);
        $query->bindValue('balance', $account->getBalance(), PDO::PARAM_INT);
        $query->execute();

    }


    /**
     * existAccount function 
     * @return $reponse['count'] 
     */
    public function existAccount()
    {
        $query = $this->getDb()->prepare('SELECT COUNT(id) as count  FROM accounts WHERE name = :name');
        $query->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $query->execute();
        $reponse = $query->fetch();
        return $reponse['count'] ?? null;
    }


    /**
     * getAccounts function
     * @return $arrayOfAccounts
     */
    public function getAccounts()
    {
        $arrayOfAccounts = [];

        $query = $this->getDb()->prepare('SELECT * FROM accounts');
        $query->execute();
        $dataAccounts = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($dataAccounts as $account) {
            $arrayOfAccounts[] = new Account($account);
        }
        return $arrayOfAccounts;
    }


    /**
     * getAccountId function
     * @param integer $id
     * @return $accountId
     */
    public function getAccountId(int $id)
    {
        $accountId = "";
        $accountById = $this->getDb()->prepare("SELECT * FROM accounts WHERE id = :id");
        $accountById->execute(array(
            'id' => $id
        ));
        $accounts = $accountById->fetchAll(PDO::FETCH_ASSOC);
        foreach ($accounts as $account) {
            $accountId = new Account($account);

        }
        return $accountId;
    }

    /**
     * deleteAccount function
     * @param Account $account
     */
    public function deleteAccount($id)
    {

        $query = $this->getDb()->prepare('DELETE  FROM accounts WHERE id = :id');
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

    }

    /**
     * updateAccount function
     * @param Account $account
     */
    public function updateAccount(Account $account)
    {
        $query = $this->getDb()->prepare('UPDATE accounts SET balance = :balance WHERE id = :id');
        $query->bindValue(':id', $account->getId(), PDO::PARAM_INT);
        $query->bindValue(':balance', $account->getBalance(), PDO::PARAM_INT);
        $query->execute();
    }


}
