-- ----------------------------
-- Table structure for Users
-- ----------------------------
DROP TABLE IF EXISTS public.users CASCADE;
CREATE TABLE public.users (
    id_user SERIAL PRIMARY KEY,            -- Unique identifier for each user
    username VARCHAR(100) NOT NULL UNIQUE, -- Unique username for the user
    email VARCHAR(255) NOT NULL UNIQUE,    -- Unique email address for the user
    hashed_password VARCHAR(100) NOT NULL  -- Password stored in hashed format
);

-- ----------------------------
-- Table structure for Roles
-- ----------------------------
DROP TABLE IF EXISTS public.roles CASCADE;
CREATE TABLE public.roles (
    id_role SERIAL PRIMARY KEY,            -- Unique identifier for each role
    role VARCHAR(100) NOT NULL UNIQUE      -- Name of the role (e.g., "Admin")
);

-- ----------------------------
-- Table structure for Admins
-- ----------------------------
DROP TABLE IF EXISTS public.admins CASCADE;
CREATE TABLE public.admins (
    id_admin SERIAL PRIMARY KEY,           -- Unique identifier for the admin entry
    id_role INTEGER NOT NULL,              -- Reference to a role from the roles table
    id_user INTEGER NOT NULL,              -- Reference to a user from the users table
    FOREIGN KEY (id_role) REFERENCES public.roles(id_role), -- Ensures role integrity
    FOREIGN KEY (id_user) REFERENCES public.users(id_user)  -- Ensures user integrity
);

-- ----------------------------
-- Table structure for User_info
-- ----------------------------
DROP TABLE IF EXISTS public.user_info CASCADE;
CREATE TABLE public.user_info (
    name VARCHAR(100),                     -- First name of the user
    surname VARCHAR(100),                  -- Surname of the user
    summary VARCHAR(100),                  -- Short summary or bio of the user
    id_user INTEGER NOT NULL UNIQUE,       -- Unique reference to the user
    FOREIGN KEY (id_user) REFERENCES public.users(id_user) -- Ensures user integrity
);

-- ----------------------------
-- Table structure for Sessions
-- ----------------------------
DROP TABLE IF EXISTS public.sessions CASCADE;
CREATE TABLE public.sessions (
    id_session SERIAL PRIMARY KEY,         -- Unique identifier for the session
    session_token VARCHAR(255) NOT NULL UNIQUE, -- Unique token for the session
    id_user INTEGER NOT NULL,              -- Reference to the user who owns the session
    expiration_date TIMESTAMP NOT NULL,    -- Expiration date and time of the session
    FOREIGN KEY (id_user) REFERENCES public.users(id_user) -- Ensures user integrity
);

-- ----------------------------
-- Table structure for Books
-- ----------------------------
DROP TABLE IF EXISTS public.books CASCADE;
CREATE TABLE public.books (
    id_book SERIAL PRIMARY KEY,            -- Unique identifier for the book
    title VARCHAR(255) NOT NULL,           -- Title of the book (must be unique with description)
    description VARCHAR(255) NOT NULL,    -- Description of the book
    cover VARCHAR(255),                    -- Path or URL for the cover image (if available)
    UNIQUE (title, description)            -- Ensures no duplicate entries for title & description
);

-- ----------------------------
-- Table structure for Comments
-- ----------------------------
DROP TABLE IF EXISTS public.comments CASCADE;
CREATE TABLE public.comments (
    id_comment SERIAL PRIMARY KEY,         -- Unique identifier for the comment
    comment VARCHAR(255) NOT NULL,         -- The actual comment text
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Date and time of the comment
    id_user INTEGER NOT NULL,              -- Reference to the user who made the comment
    id_book INTEGER NOT NULL,              -- Reference to the book being commented on
    FOREIGN KEY (id_book) REFERENCES public.books(id_book), -- Ensures book integrity
    FOREIGN KEY (id_user) REFERENCES public.users(id_user)  -- Ensures user integrity
);

-- ----------------------------
-- Table structure for Tags
-- ----------------------------
DROP TABLE IF EXISTS public.tags CASCADE;
CREATE TABLE public.tags (
    id_tag SERIAL PRIMARY KEY,             -- Unique identifier for the tag
    tag VARCHAR(100) NOT NULL UNIQUE       -- The name of the tag (e.g., "Fiction")
);

-- ----------------------------
-- Table structure for Book_tags
-- ----------------------------
DROP TABLE IF EXISTS public.book_tags CASCADE;
CREATE TABLE public.book_tags (
    id_book INTEGER NOT NULL,              -- Reference to a book
    id_tag INTEGER NOT NULL,               -- Reference to a tag
    PRIMARY KEY (id_book, id_tag),         -- Composite primary key to ensure unique pairs
    FOREIGN KEY (id_book) REFERENCES public.books(id_book), -- Ensures book integrity
    FOREIGN KEY (id_tag) REFERENCES public.tags(id_tag)     -- Ensures tag integrity
);

-- ----------------------------
-- Table structure for Genres
-- ----------------------------
DROP TABLE IF EXISTS public.genres CASCADE;
CREATE TABLE public.genres (
    id_genre SERIAL PRIMARY KEY,           -- Unique identifier for the genre
    genre VARCHAR(100) NOT NULL UNIQUE     -- Name of the genre (e.g., "Fantasy")
);

-- ----------------------------
-- Table structure for Book_genres
-- ----------------------------
DROP TABLE IF EXISTS public.book_genres CASCADE;
CREATE TABLE public.book_genres (
    id_book INTEGER NOT NULL,              -- Reference to a book
    id_genre INTEGER NOT NULL,             -- Reference to a genre
    PRIMARY KEY (id_book, id_genre),       -- Composite primary key to ensure unique pairs
    FOREIGN KEY (id_book) REFERENCES public.books(id_book), -- Ensures book integrity
    FOREIGN KEY (id_genre) REFERENCES public.genres(id_genre) -- Ensures genre integrity
);

-- ----------------------------
-- Table structure for Authors
-- ----------------------------
DROP TABLE IF EXISTS public.authors CASCADE;
CREATE TABLE public.authors (
    id_author SERIAL PRIMARY KEY,          -- Unique identifier for the author
    author VARCHAR(255) NOT NULL           -- Name of the author
);

-- ----------------------------
-- Table structure for Book_authors
-- ----------------------------
DROP TABLE IF EXISTS public.book_authors CASCADE;
CREATE TABLE public.book_authors (
    id_book INTEGER NOT NULL,              -- Reference to a book
    id_author INTEGER NOT NULL,            -- Reference to an author
    PRIMARY KEY (id_book, id_author),      -- Composite primary key to ensure unique pairs
    FOREIGN KEY (id_book) REFERENCES public.books(id_book), -- Ensures book integrity
    FOREIGN KEY (id_author) REFERENCES public.authors(id_author) -- Ensures author integrity
);

-- ----------------------------
-- Function to delete expired sessions
-- ----------------------------
CREATE OR REPLACE FUNCTION delete_expired_sessions()
RETURNS void AS $$
    BEGIN
    DELETE FROM public.sessions
    WHERE expiration_date < NOW();             -- Remove sessions that have expired
END;
$$ LANGUAGE plpgsql;

-- ----------------------------
-- Cron job to automate deletion of expired sessions
-- ----------------------------
CREATE EXTENSION IF NOT EXISTS pg_cron;

SELECT cron.schedule('delete_expired_sessions', '0 */1 * * *', $$
    SELECT delete_expired_sessions();
$$);

-- ----------------------------
-- View structure for Book_details
-- ----------------------------
CREATE VIEW book_details AS
SELECT
    b.id_book,                             -- Book identifier
    b.title,                               -- Book title
    b.description,                         -- Book description
    b.cover,                               -- Book cover image URL/path
    ARRAY_AGG(DISTINCT a.author) AS authors, -- List of authors for the book
    ARRAY_AGG(DISTINCT t.tag) AS tags,     -- List of tags for the book
    ARRAY_AGG(DISTINCT g.genre) AS genres  -- List of genres for the book
FROM
    books b
        LEFT JOIN book_authors ba ON b.id_book = ba.id_book -- Join with book_authors
        LEFT JOIN authors a ON ba.id_author = a.id_author   -- Join with authors
        LEFT JOIN book_tags bt ON b.id_book = bt.id_book    -- Join with book_tags
        LEFT JOIN tags t ON bt.id_tag = t.id_tag            -- Join with tags
        LEFT JOIN book_genres bg ON b.id_book = bg.id_book  -- Join with book_genres
        LEFT JOIN genres g ON bg.id_genre = g.id_genre      -- Join with genres
GROUP BY
    b.id_book, b.title, b.description;     -- Group data to ensure distinct results for each book