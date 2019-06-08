var table = $('#dataTables-example').DataTable();

$(document).ready(function () {
    table.DataTable({
//                responsive: true,
        columnDefs: [
            {
                targets: [ 0 ],
                className: 'mdl-data-table__cell--non-numeric'
            }
        ],
        select: true
    });
});
table.on( 'select', function ( e, dt, type, indexes ) {
    if ( type === 'row' ) {
        var data = table.rows( indexes ).data().pluck( 'id' );

        console.log(data);
    }
} );

