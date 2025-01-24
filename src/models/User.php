<?php

class User {
    private $id;
    private $username;
    private $email;
    private $hashed_password;
    private $avatarUrl;

    public function __construct(
        string $username,
        string $email,
        string $hashed_password
    )
    {
        $this->username = $username;
        $this->email = $email;
        $this->hashed_password = $hashed_password;
        $this->id = null;
        $this->avatarUrl = null;
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

    public function getAvatarUrl()
    {
        return $this->avatarUrl;
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

    public function setAvatarUrl(string $avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
    }
}
