delimiter //
 create trigger anula_venta
   after delete on detalle_ventas
   for each row
 begin
 declare nroventa int default 0;
 set nroventa = old.venta_nro;
 
 DELETE FROM ventas where idventas = nroventa;
  
     
 end ;