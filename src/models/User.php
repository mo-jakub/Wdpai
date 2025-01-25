<?php

class User {
    private int $id;
    private string $username;
    private string $email;
    private string $hashed_password;

    public function __construct(
        string $username,
        string $email,
        string $hashed_password
    )
    {
        $this->username = $username;
        $this->email = $email;
        $this->hashed_password = $hashed_password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getHashedPassword()
    {
        return $this->hashed_password;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setHashedPassword(string $hashed_password)
    {
        $this->hashed_password = $hashed_password;
    }
}
