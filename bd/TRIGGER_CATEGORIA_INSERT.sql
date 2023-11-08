delimiter //
 create trigger after_insert_categoria
   after delete on categorias
   for each row
 begin
 declare codigo int default 0;
 declare tabla varchar(50) default " ";
 declare codigocategoria int default 0;
 
 set codigo = new.id_usuario;
 set codigocategoria = new.id_categoria;
 set tabla = CONCAT("CATEGORIA= ", new.nombreCategoria);
 
  INSERT INTO auditoria(id_usuario,accion,fecha_hora,tabla,codigo) values (codigo,"INSERCION",NOW(),texto,codigocategoria);
     
 end ;