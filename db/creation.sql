BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "usuario" (
	"idUsuario"	INTEGER,
	"nickname"	varchar(32) NOT NULL UNIQUE,
	"senha"	varchar(60),
	PRIMARY KEY("idUsuario" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "todo" (
	"idTodo"	INTEGER,
	"tituloTodo"	VARCHAR(64) NOT NULL,
	"descricaoTodo"	VARCHAR(512),
	"idUsuario"	INTEGER NOT NULL,
	FOREIGN KEY("idUsuario") REFERENCES "usuario"("idUsuario"),
	PRIMARY KEY("idTodo" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "sessao" (
	"hashSessao"	VARCHAR(32),
	"idUsuario"	INTEGER,
	"expiraEm"	CHAR(24),
	FOREIGN KEY("idUsuario") REFERENCES "usuario"("idUsuario"),
	PRIMARY KEY("hashSessao")
);
COMMIT;
