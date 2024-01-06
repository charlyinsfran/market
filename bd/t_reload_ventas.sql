delimiter //
 create trigger after_anularventa
 
   after DELETE on detalle_ventas
   for each row
 begin
 declare codigo int default 0;
 declare cantidaddelete int default 0;
 
 set codigo = old.idproducto;
 set cantidaddelete = old.cantidad;
 
UPDATE productos set cantidad = cantidad + cantidaddelete
where id_producto = codigo;
 end;