create table grupo(
idGrupo int primary key auto_increment,
nombreGrupo varchar (20) not null
)engine=Innodb;

create table usuario(
idUsuario int primary key,
nombreUsuario varchar(40) not null,
clave varchar(150) not null,
rol varchar(15) not null 
)engine=Innodb;

create table matricula(
idMatricula int primary key auto_increment,
grupoIdGrupo int not null,
alumnoIdAlumno int not null,
foreign key (grupoIdGrupo) references grupo (idGrupo),
foreign key (alumnoIdAlumno) references alumno (carnet)
)engine=Innodb;

create table inscripcionComponentes(
idInscripcion int primary key auto_increment,
materiaIdMateria int not null,
alumnoInscripcion int not null,
foreign key (materiaIdMateria) references materia (id),
foreign key (alumnoInscripcion) references alumno (carnet)
)engine=Innodb;


create table docente(
idDocente int primary key auto_increment,
nombreDocente varchar(40) not null,
especialidad varchar(40) not null,
nombreUsuarioDocente varchar(40) not null
)engine=Innodb;


create table asignacionComponentes(
idAsignacion int primary key auto_increment,
docenteIdDocente int not null,
materiaAsignacion int not null,
foreign key (docenteIdDocente) references docente (idDocente),
foreign key (materiaAsignacion) references materia (id)
)engine=Innodb;

create table notas(
idNota int primary key auto_increment,
alumnoNota int not null,
docenteNota int not null,
materiaNota int not null,
IP float not null,
IIP float not null,
IIIP float not null,
NF float not null,
foreign key (alumnoNota) references alumno (carnet),
foreign key (docenteNota) references docente (idDocente),
foreign key (materiaNota) references materia (id)
)engine=Innodb;