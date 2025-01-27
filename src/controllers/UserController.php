<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/CommentRepository.php';

class UserController extends AppController
{
    private UserRepository $userRepository;
    private CommentRepository $commentRepository;

    public function __construct()
    {
        parent::__construct();
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();
    }

    public function user($id): void
    {
        $user = $this->userRepository->getUserById((int) $id);
        $comments = $this->commentRepository->getCommentsByUserId($id);

        if (!$user) {
            $this->render('errors/ErrorDB');
            return;
        }

        $this->render('user', ['user' => $user, 'comments' => $comments]);
    }
}