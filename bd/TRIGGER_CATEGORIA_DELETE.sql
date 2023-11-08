delimiter //
 create trigger delete_categoria
   after delete on categorias
   for each row
 begin
 declare codigo1 int default 0;
 declare codigo2 int default 0;
 declare texto varchar(30);
 
 set codigo1 = old.id_usuario;
 set codigo2 = old.id_categoria;
 set texto = "categoria";
 
 
  INSERT INTO auditoria(id_usuario,accion,fecha_hora,tabla,codigo) values (codigo1,"ELIMINACION",NOW(),CONCAT(texto,", ", old.nombreCategoria),codigo2);
     
 end ;