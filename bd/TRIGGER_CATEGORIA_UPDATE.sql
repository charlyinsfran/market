delimiter //
 create trigger UPDATE_categoria
   after update on categorias
   for each row
 begin
 declare codigo int default 0;
 declare tabla varchar(50) default " ";
 declare codigocategoria int default 0;
 
 set codigo = new.id_usuario;
 set codigocategoria = new.id_categoria;
 set tabla = CONCAT("CATEGORIA= ", old.nombreCategoria);
 
  INSERT INTO auditoria(id_usuario,accion,fecha_hora,tabla,codigo) values (codigo,"MODIFICACION",NOW(),tabla,codigocategoria);
     
 end ;