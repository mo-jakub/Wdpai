CREATE TABLE public.users (
    id_user SERIAL PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    hashed_password VARCHAR(100) NOT NULL
);

CREATE TABLE public.roles (
    id_role SERIAL PRIMARY KEY,
    role VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE public.admins (
    id_admin SERIAL PRIMARY KEY,
    id_role INTEGER NOT NULL,
    id_user INTEGER NOT NULL,
    FOREIGN KEY (id_role) REFERENCES public.roles(id_role),
    FOREIGN KEY (id_user) REFERENCES public.users(id_user)
);

CREATE TABLE public.user_info (
   id_info SERIAL PRIMARY KEY,
   name VARCHAR(100),
   surname VARCHAR(100),
   id_user INTEGER NOT NULL,
   FOREIGN KEY (id_user) REFERENCES public.users(id_user)
);

CREATE TABLE public.sessions (
    id_session SERIAL PRIMARY KEY,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    id_user INTEGER NOT NULL,
    expiration_date TIMESTAMP WITH TIME ZONE NOT NULL,
    FOREIGN KEY (id_user) REFERENCES public.users(id_user)
);

CREATE TABLE public.books (
    id_book SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL
);

CREATE TABLE public.comments (
    id_comment SERIAL PRIMARY KEY,
    comment VARCHAR(255) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_user INTEGER NOT NULL,
    id_book INTEGER NOT NULL,
    FOREIGN KEY (id_book) REFERENCES public.books(id_book),
    FOREIGN KEY (id_user) REFERENCES public.users(id_user)
);

CREATE TABLE public.tags (
    id_tag SERIAL PRIMARY KEY,
    tag VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE public.book_tags (
    id_book INTEGER NOT NULL,
    id_tag INTEGER NOT NULL,
    PRIMARY KEY (id_book, id_tag),
    FOREIGN KEY (id_book) REFERENCES public.books(id_book),
    FOREIGN KEY (id_tag) REFERENCES public.tags(id_tag)
);

CREATE TABLE public.genres (
    id_genre SERIAL PRIMARY KEY,
    genre VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE public.book_genres (
    id_book INTEGER NOT NULL,
    id_genre INTEGER NOT NULL,
    PRIMARY KEY (id_book, id_genre),
    FOREIGN KEY (id_book) REFERENCES public.books(id_book),
    FOREIGN KEY (id_genre) REFERENCES public.genres(id_genre)
);

CREATE TABLE public.authors (
    id_author SERIAL PRIMARY KEY,
    author VARCHAR(255) NOT NULL
);

CREATE TABLE public.book_authors (
    id_book INTEGER NOT NULL,
    id_author INTEGER NOT NULL,
    PRIMARY KEY (id_book, id_author),
    FOREIGN KEY (id_book) REFERENCES public.books(id_book),
    FOREIGN KEY (id_author) REFERENCES public.authors(id_author)
);