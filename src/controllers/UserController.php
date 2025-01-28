<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/CommentRepository.php';
require_once __DIR__ . '/../repositories/UserInfoRepository.php';

class UserController extends AppController
{
    private UserRepository $userRepository;
    private CommentRepository $commentRepository;
    private UserInfoRepository $userInfoRepository;

    public function __construct()
    {
        parent::__construct();
        $this->commentRepository = new CommentRepository();
        $this->userRepository = new UserRepository();
        $this->userInfoRepository = new UserInfoRepository();
    }

    public function user($id): void
    {
        $user = $this->userRepository->getUserById((int) $id);
        $userInfo = $this->userInfoRepository->getUserInfoById((int) $id);
        $comments = $this->commentRepository->getCommentsByUserId((int) $id);

        if (!$user) {
            $this->render('errors/ErrorDB');
            return;
        }

        $action = $_GET['action'] ?? '';

        $this->render('user', ['user' => $user, 'userInfo' => $userInfo,'comments' => $comments, 'action' => $action]);
    }
}