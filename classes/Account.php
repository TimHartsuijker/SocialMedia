<?php

declare(strict_types=1);

class Account
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    private function __construct(int $id, string $name, string $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getID(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function get(int $id): ?Account
    {
        $params = array(":id" => $id);
        $sth = getPDO()->prepare("SELECT `id`, `name`, `email`, `password` FROM `accounts` WHERE `id` = :id LIMIT 1;");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Customer($id, $row["name"], $row["email"], $row["password"]);

        return null;
    }

    public static function getAll(): array
    {
        $sth = getPDO()->prepare("SELECT `id`, `name`, `email`, `password` FROM `accounts`;");
        $sth->execute();

        $accounts = array();

        while ($row = $sth->fetch())
            $accounts[$row["id"]] = new Customer($row["id"], $row["name"], $row["email"], $row["password"]);

        return $accounts;
    }

    public static function create(string $name, string $email, string $password)
    {
        $params = array(
            ":name" => $name,
            ":email" => $email,
            ":password" => $password
        );
        $sth = getPDO()->prepare(
            "INSERT INTO `accounts` (`name`, `email`, `password`) VALUES (:name, :email, :password)"
        );
        $sth->execute($params);
    }

    public static function update(int $id, string $name, string $email, string $password)
    {
        $params = array(
            ":id" => $id,
            ":name" => $name,
            ":email" => $email,
            ":password" => $password
        );
        $sth = getPDO()->prepare(
            "UPDATE `accounts`
            SET `name` = :name,
                `email` = :email,
                `password` = :password
            WHERE `id` = :id;"
        );
        $sth->execute($params);
    }

    public static function delete(int $id)
    {
        Reservation::deleteByCustomerID($id);

        $params = array(":id" => $id);
        $sth = getPDO()->prepare("DELETE FROM `accounts` WHERE `id` = :id");
        $sth->execute($params);
    }

    public static function getByEmail(string $email): ?Account
    {
        $params = array(":email" => $email);
        $sth = getPDO()->prepare("SELECT `id`, `name`, `password` FROM `accounts` WHERE `email` = :email");
        $sth->execute($params);

        if ($row = $sth->fetch())
            return new Account($row["id"], $row["name"], $email, $row["password"]);

        return null;
    }





}