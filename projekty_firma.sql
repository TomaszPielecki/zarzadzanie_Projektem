CREATE DATABASE IF NOT EXISTS projekty_firma;

USE projekty_firma;

CREATE TABLE IF NOT EXISTS projekty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nazwa VARCHAR(255) NOT NULL,
    opis TEXT NOT NULL,
    data_rozpoczecia DATE NOT NULL,
    data_zakonczenia DATE,
    status ENUM('zakończony', 'w trakcie') NOT NULL,
    odpowiedzialny VARCHAR(255) NOT NULL
);

-- Dodaj przykładowe dane
INSERT INTO projekty (nazwa, opis, data_rozpoczecia, data_zakonczenia, status, odpowiedzialny) VALUES
('Projekt A', 'Opis projektu A', '2023-01-01', NULL, 'w trakcie', 'Jan Kowalski'),
('Projekt B', 'Opis projektu B', '2022-06-15', '2023-08-01', 'zakończony', 'Anna Nowak'),
('Projekt C', 'Opis projektu C', '2023-03-10', NULL, 'w trakcie', 'Piotr Wiśniewski');
