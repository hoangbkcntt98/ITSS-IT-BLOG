<div class="ratting-stars">
    <form class="rating" id="rating" method="POST" action="#">
        <input type="radio" id="star5" name="rating" value="5"/><label class="full" for="star5"
                                                                       title="Awesome - 5 stars"></label>
        <input type="radio" id="star4half" name="rating" value="4.5"/><label class="half" for="star4half"
                                                                                      title="Pretty good - 4.5 stars"></label>
        <input type="radio" id="star4" name="rating" value="4"/><label class="full" for="star4"
                                                                       title="Pretty good - 4 stars"></label>
        <input type="radio" id="star3half" name="rating" value="3.5"/><label class="half" for="star3half"
                                                                                      title="Meh - 3.5 stars"></label>
        <input type="radio" id="star3" name="rating" value="3"/><label class="full" for="star3"
                                                                       title="Meh - 3 stars"></label>
        <input type="radio" id="star2half" name="rating" value="2.5"/><label class="half" for="star2half"
                                                                                      title="Kinda bad - 2.5 stars"></label>
        <input type="radio" id="star2" name="rating" value="2"/><label class="full" for="star2"
                                                                       title="Kinda bad - 2 stars"></label>
        <input type="radio" id="star1half" name="rating" value="1.5"/><label class="half" for="star1half"
                                                                                      title="Meh - 1.5 stars"></label>
        <input type="radio" id="star1" name="rating" value="1"/><label class="full" for="star1"
                                                                       title="Sucks big time - 1 star"></label>
        <input type="radio" id="starhalf" name="rating" value="0.5"/><label class="half" for="starhalf"
                                                                             title="Sucks big time - 0.5 stars"></label>
    </form>
</div>
<script type="text/javascript">
    $('#rating').change('rating', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        e.preventDefault();
        var ratting_value = $("input[name='rating']:checked").val();
        var pathUrl = window.location.pathname;
        $.ajax({
            type: 'POST',
            cache: false,
            dataType: 'JSON',
            url: '/product-details/rate',
            data: {
                'rate': ratting_value,
                'prod_id': pathUrl.split("/", 3)[2]
            },
            success: function (data) {
                var dataJson = JSON.parse(JSON.stringify(data));
                console.log(dataJson["stars_rate"]);
                $("#vote-stars-result").html(function (data){
                    return "<b>Vote Rate: <i>(Total Rate:" + dataJson["count_rates"] + " votes, rate average " + dataJson["stars_rate"] + ")</i></b>\n"
                })
            },
            error: function (data) {
                console.log("error post rating stars " + data);
            }
        });
    })
</script>
