delimiter //
 create trigger after_insert_ventas
   after INSERT on detalle_ventas
   for each row
 begin
 declare codigo int default 0;
 declare tabla varchar(50) default " ";
 declare codigocategoria int default 0;
 declare codigousuario int default 0;
 declare nombreproducto VARCHAR(50) default "";
 declare descripcionproducto VARCHAR(50) default "";
 declare precioproducto FLOAT default 0;
 declare ivaproducto int default 0;
 declare fechaguardado datetime ;
 declare texto VARCHAR(1000) default "";

 set codigo = new.id_producto;
 set tabla = "productos";
 set codigocategoria = new.id_categoria;
 set codigousuario = new.id_usuario;
 set nombreproducto = new.nombre;
 set descripcionproducto = new.descripcion;
 set precioproducto = new.precio;
 set ivaproducto = new.iva;
 set fechaguardado = new.fechaCaptura;
 
 
  INSERT INTO auditoria(id_usuario,accion,fecha_hora,tabla,codigo) 
  values (codigousuario,"INSERCION",NOW(),
  CONCAT("NOMBRE= ",nombreproducto," DESCRIPCION= ",descripcionproducto,
  " COD CATEGORIA= ",codigocategoria," PRECIO= ",precioproducto," IVA= ",ivaproducto),codigo);
     
 end ;