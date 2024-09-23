  //add client review alert custome js
  $('body').on('submit', '#submit_blog', function (e) {
    e.preventDefault();

    $.ajax({
      url: $(this).attr('action'),
      method: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data.status == 200) {
          $.notification(
            [data.msg],
            {
              position: ['top', 'right'],
              messageType: 'success',
              timeView: 1000,
            }
          )

          setTimeout(function () {
            window.location.href = '/blog/manage';
          }, 3000);

        } else {
          $.notification(
            [data.msg],
            {
              position: ['top', 'right'],
              messageType: 'error',
              timeView: 1000,
            }
          )
        }
      }
    })
  })

  // blog category
  $('body').on('submit', '#submit_blog_category', function (e) {
    e.preventDefault();

    $.ajax({
      url: $(this).attr('action'),
      method: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data.status == 200) {
          $.notification(
            [data.msg],
            {
              position: ['top', 'right'],
              messageType: 'success',
              timeView: 1000,
            }
          )

          setTimeout(function () {
            window.location.href = '/blog/category/manage';
          }, 3000);

        } else {
          $.notification(
            [data.msg],
            {
              position: ['top', 'right'],
              messageType: 'error',
              timeView: 1000,
            }
          )
        }
      }
    })
  })