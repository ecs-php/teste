var $home = new Vue({
  el: '.page-home,#taskEditModal',
  data: {
    title: 'Tasks',
    selectedTask: {},
    tasks: []
  },
  methods: {
    loadTasks: function () {
      var _this = this;
      var $term = $('#taskSearch').val();

      _this.title = 'Loading Tasks...';

      $.get('./api/Task', {term: $term}, function (r) {
        _this.title = 'Tasks';
        _this.tasks = r.results;
      });
    },

    addTask: function(data) {
      $.post('./api/Task/', data, function (r) {
        $home.loadTasks();
      });
    },

    openTask: function (id) {
      var _this = this;
      _this.selectedTask = _this.tasks.filter(i => i.id == id)[0];

      $('#taskEditModal').modal('show');
    },

    deleteTask: function (id) {
      var _this = this;
      $.ajax({
        method: 'DELETE',
        url: './api/Task/',
        data: {
          id: id
        },
        success: function(r) {
          if (r == 1) {
            $('#taskEditModal').modal('hide');
            $home.loadTasks();
          } else alert('Whoops, looks like something went wrong;')
        }
      })
    }
  },
  mounted: function () {
    this.loadTasks();
  },
});

$(document).on('click', '[data-action="edit-task"]', function (ev){
  ev.preventDefault();
  var itemId = $(this).attr('data-key');
  $home.openTask(itemId);
});

$(document).on('click', '[data-action="delete-task"]', function (ev){
  ev.preventDefault();
  var $this = $(this);
  var itemId = $(this).attr('data-key');
  if (confirm('Remove task?')) {
    $home.deleteTask(itemId);
  }
});

$(document).on('submit', '#taskEditModal form', function (ev) {
  ev.preventDefault();
  var $this = $(this);
  var id = $this.find('[name="id"]').val();

  $.ajax({
    method: 'PUT',
    data: $this.serialize(),
    url: './api/Task/' + id,
    success: function (r) {
      if (r == 1) {
        $('#taskEditModal').modal('hide');
        $home.loadTasks();
      } else {
        alert('Invalid data or no changes detected');
      }
    }
  })
});

$(document).on('submit', '#formAddTask', function (ev) {
  ev.preventDefault();
  var $this = $(this);

  $home.addTask($this.serialize());
});

$(document).on('keyup', '#taskSearch', function (ev) {
  $home.loadTasks();
});