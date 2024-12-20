CREATE TABLE public.books (
    id_book SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    id_authors INTEGER NOT NULL
);

CREATE TABLE public.genres (
    id_genre SERIAL PRIMARY KEY,
    genre VARCHAR(100) NOT NULL
);

CREATE TABLE public.book_genres (
    id_book INTEGER NOT NULL,
    id_genre INTEGER NOT NULL,
    PRIMARY KEY (id_book, id_genre)
);

CREATE TABLE public.book_authors (
    id_book INTEGER NOT NULL,
    id_author INTEGER NOT NULL,
    PRIMARY KEY (id_book, id_author)
);

CREATE TABLE public.authors (
    id_author SERIAL PRIMARY KEY,
    author VARCHAR(255) NOT NULL
);

INSERT INTO public.genres (genre) VALUES
('Fantasy'),
('Science Fiction'),
('Mystery'),
('Romance'),
('Horror'),
('Thriller'),
('Non-fiction'),
('Historical'),
('Adventure'),
('Biography');

INSERT INTO public.books (title, id_authors) VALUES
-- Fantasy
('The Hobbit', 1),
('Harry Potter and the Sorcerer''s Stone', 2),
('The Name of the Wind', 3),
('A Game of Thrones', 4),
('Mistborn: The Final Empire', 5),
('The Way of Kings', 5),
('Good Omens', 6),
('The Lies of Locke Lamora', 7),
('The Last Unicorn', 8),
('The Witcher: The Last Wish', 9),

-- Science Fiction
('Dune', 10),
('Neuromancer', 11),
('Foundation', 12),
('Snow Crash', 13),
('Hyperion', 14),
('The Left Hand of Darkness', 15),
('Ender''s Game', 16),
('The War of the Worlds', 17),
('The Three-Body Problem', 18),
('Brave New World', 19),

-- Mystery
('The Girl with the Dragon Tattoo', 20),
('Gone Girl', 21),
('The Da Vinci Code', 22),
('In the Woods', 23),
('Big Little Lies', 24),
('Sharp Objects', 21),
('The Silent Patient', 25),
('The Hound of the Baskervilles', 26),
('And Then There Were None', 27),
('The Woman in the Window', 28),

-- Romance
('Pride and Prejudice', 29),
('The Notebook', 30),
('Me Before You', 31),
('Outlander', 32),
('Bridgerton: The Duke and I', 33),
('Twilight', 34),
('The Hating Game', 35),
('Red, White & Royal Blue', 36),
('Beach Read', 37),
('People We Meet on Vacation', 38),

-- Horror
('The Shining', 39),
('Dracula', 40),
('Frankenstein', 41),
('It', 39),
('The Haunting of Hill House', 42),
('Pet Sematary', 39),
('Bird Box', 43),
('The Exorcist', 44),
('House of Leaves', 45),
('The Silence of the Lambs', 46);

INSERT INTO public.book_genres (id_book, id_genre) VALUES
-- Fantasy
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1),
(6, 1), (7, 1), (8, 1), (9, 1), (10, 1),

-- Science Fiction
(11, 2), (12, 2), (13, 2), (14, 2), (15, 2),
(16, 2), (17, 2), (18, 2), (19, 2), (20, 2),

-- Mystery
(21, 3), (22, 3), (23, 3), (24, 3), (25, 3),
(26, 3), (27, 3), (28, 3), (29, 3), (30, 3),

-- Romance
(31, 4), (32, 4), (33, 4), (34, 4), (35, 4),
(36, 4), (37, 4), (38, 4), (39, 4), (40, 4),

-- Horror
(41, 5), (42, 5), (43, 5), (44, 5), (45, 5),
(46, 5), (47, 5), (48, 5), (49, 5), (50, 5);

INSERT INTO public.authors (author) VALUES
('J.R.R. Tolkien'), ('J.K. Rowling'), ('Patrick Rothfuss'),
('George R.R. Martin'), ('Brandon Sanderson'), ('Terry Pratchett'),
('Scott Lynch'), ('Peter S. Beagle'), ('Andrzej Sapkowski'),
('Frank Herbert'), ('William Gibson'), ('Isaac Asimov'),
('Neal Stephenson'), ('Dan Simmons'), ('Ursula K. Le Guin'),
('Orson Scott Card'), ('H.G. Wells'), ('Liu Cixin'),
('Aldous Huxley'), ('Stieg Larsson'), ('Gillian Flynn'),
('Dan Brown'), ('Tana French'), ('Liane Moriarty'),
('Alex Michaelides'), ('Arthur Conan Doyle'), ('Agatha Christie'),
('A.J. Finn'), ('Jane Austen'), ('Nicholas Sparks'),
('Jojo Moyes'), ('Diana Gabaldon'), ('Julia Quinn'),
('Stephenie Meyer'), ('Sally Thorne'), ('Casey McQuiston'),
('Emily Henry'), ('Stephen King'), ('Bram Stoker'),
('Mary Shelley'), ('Shirley Jackson'), ('Josh Malerman'),
('William Peter Blatty'), ('Mark Z. Danielewski'), ('Thomas Harris');

INSERT INTO public.book_authors (id_book, id_author) VALUES
(1, 1), (2, 2), (3, 3), (4, 4), (5, 5),
(6, 5), (7, 6), (8, 7), (9, 8), (10, 9),
(11, 10), (12, 11), (13, 12), (14, 13), (15, 14),
(16, 15), (17, 16), (18, 17), (19, 18), (20, 19),
(21, 20), (22, 21), (23, 22), (24, 23), (25, 24),
(26, 25), (27, 26), (28, 27), (29, 28), (30, 29),
(31, 30), (32, 31), (33, 32), (34, 33), (35, 34),
(36, 35), (37, 36), (38, 37), (39, 38), (40, 39),
(41, 40), (42, 41), (43, 39), (44, 42), (45, 43),
(46, 44), (47, 45), (48, 46), (49, 39), (50, 46);