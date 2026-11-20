DROP DATABASE IF EXISTS biblioteca;
CREATE DATABASE biblioteca CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biblioteca;

CREATE TABLE Libros (
    libro_id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    autor VARCHAR(100) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    anio_publicacion INT NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Miembros (
    miembro_id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(60) NOT NULL,
    apellido VARCHAR(60) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    fecha_suscripcion DATE NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Prestamos (
    prestamo_id INT AUTO_INCREMENT PRIMARY KEY,
    libro_id INT NOT NULL,
    miembro_id INT NOT NULL,
    fecha_prestamo DATE NOT NULL,
    fecha_devolucion DATE NULL,
    estado ENUM('Prestado','Devuelto') NOT NULL DEFAULT 'Prestado',
    CONSTRAINT fk_prestamo_libro FOREIGN KEY (libro_id) REFERENCES Libros(libro_id) ON DELETE RESTRICT,
    CONSTRAINT fk_prestamo_miembro FOREIGN KEY (miembro_id) REFERENCES Miembros(miembro_id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO Libros (titulo, autor, genero, anio_publicacion) VALUES
('Cien años de soledad', 'Gabriel García Márquez', 'Novela', 1967),
('Huasipungo', 'Jorge Icaza', 'Novela', 1934),
('El principito', 'Antoine de Saint-Exupéry', 'Fábula', 1943),
('1984', 'George Orwell', 'Ciencia ficción', 1949),
('Don Quijote de la Mancha', 'Miguel de Cervantes', 'Clásico', 1605),
('Clean Code', 'Robert C. Martin', 'Tecnología', 2008);

INSERT INTO Miembros (nombre, apellido, email, fecha_suscripcion) VALUES
('Ana', 'Torres', 'ana.torres@correo.com', '2026-01-15'),
('Luis', 'Mendoza', 'luis.mendoza@correo.com', '2026-03-02'),
('María', 'Paredes', 'maria.paredes@correo.com', '2026-06-20');

INSERT INTO Prestamos (libro_id, miembro_id, fecha_prestamo, fecha_devolucion, estado) VALUES
(1, 1, '2026-11-01', NULL, 'Prestado'),
(4, 2, '2026-10-10', '2026-10-24', 'Devuelto'),
(3, 3, '2026-11-12', NULL, 'Prestado');
