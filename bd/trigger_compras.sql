delimiter //
 create trigger after_compras
   after INSERT on detalle_compra
   for each row
 begin
 declare nuevacantidad int default 0;
 declare codigo int default 0;
 set nuevacantidad = new.cantidad;
 set codigo = new.id_producto;
 
  update productos set productos.cantidad = productos.cantidad + nuevacantidad
     where productos.id_producto = codigo;   
 end;