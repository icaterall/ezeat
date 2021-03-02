
               <td><input type="text" class="form-control form-control-solid " name="extra_name[]"></td> 

                 @foreach($sizes as $key => $size)  
              <td><input type="text" class="form-control form-control-solid price_input" name="extra_price[{{$size->id}}][]"></td> 
                     @endforeach 
