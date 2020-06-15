<form action="{{route('filter')}}" method="GET" class="row">
    <div class="col">
        <label for="brand_id">Hãng:</label>
        <select name="brand_id" id="brand_id">
            <option value="0">Acer</option>
            <option value="3">Apple</option>
            <option value="1">Asus</option>
            <option value="2">Dell</option>
            <option value="4">HP</option>                         
            <option value="5">Lenovo</option>                          
        </select>
    </div>
    

    <div class="col">
        <label for="cpu">CPU:</label>
        <select name="cpu" id="cpu">
            <option value="Core i3">Intel Core i3</option>
            <option value="Core i5">Intel Core i5</option>
            <option value="Core i7">Intel Core i7</option>
            <option value="Core i9">Intel Core i9</option>
            <option value="Ryzen 3">Ryzen 3</option>                         
            <option value="Ryzen 5">Ryzen 5</option>     
            <option value="Ryzen 7">Ryzen 7</option>                                               
        </select>
    </div>
    
    <div class="col">
        <label for="ram">RAM:</label>
        <select name="ram" id="ram">
            <option value="4">4Gb</option>
            <option value="8">8Gb</option>
            <option value="16">16Gb</option>
            <option value="32">32Gb</option>                                             
        </select>
    </div>
    
    <div class="col">
        <label for="disk">Ổ cứng:</label>
        <select name="disk" id="disk">
            <option value="128">128Gb</option>
            <option value="256">256Gb</option>
            <option value="512">512Gb</option>
        </select>
    </div>
    
    <div class="col">
        <label for="size">Màn hình:</label>
        <select  name="size" id="size">
            <option value="12">Màn 12 Inch</option>
            <option value="13.5">Màn 13.5 Inch</option>
            <option value="14">Màn 14 Inch</option>
            <option value="15.6">Màn 15.6 Inch</option>   
            <option value="17">Màn 17 Inch</option>                                             
                                          
        </select>
    </div>
    <input type="submit" value="Search">
             
</form>