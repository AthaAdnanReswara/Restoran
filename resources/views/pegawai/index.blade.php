@extends('layouts.app')

@section('content')
    <section id="menu" class="mt-10 mb-24">
        <div class="flex justify-center items-center text-center mb-8 mx-2">
            <div>
                <h1 class="text-3xl font-bold">List Orders</h1>
                <div class="underline h-1 w-36 bg-yellow-500 mx-auto mt-2 rounded"></div>
            </div>
        </div>

        <div class="wrapper-menu mx-2">
            <!-- Grid -->
            <div id="ordersGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-2">
                <!-- Orders will be injected here via AJAX polling -->
            </div>
        </div>


    </section>
@endsection

@section('scripts')
    <script>
        const fetchPending = () => {
            fetch("{{ route('pegawai.orders.pending') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
                .then(res => res.json())
                .then(data => {
                    const grid = document.getElementById('ordersGrid');
                    if (grid && data.html !== undefined) grid.innerHTML = data.html;

                    // bind handlers
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    document.querySelectorAll('.accept-btn').forEach(btn => {
                        btn.addEventListener('click', async () => {
                            const parent = btn.closest('.item-menu');
                            const ids = Array.from(parent.querySelectorAll('.trx-id')).map(i=>i.value);
                            const res = await Swal.fire({
                                title: 'Terima pesanan?',
                                text: `Terima pesanan dari ${parent.querySelector('.font-semibold')?.textContent || ''}?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Terima',
                                cancelButtonText: 'Batal'
                            });
                            if (res.isConfirmed) {
                                for (const id of ids) {
                                    await fetch("{{ route('pegawai.orders.accept') }}", {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                                        body: JSON.stringify({ transaction_id: id })
                                    });
                                }
                                Swal.fire({toast:true, position:'top-end', icon:'success', title:'Pesanan diterima', showConfirmButton:false, timer:2000});
                                fetchPending();
                            }
                        });
                    });

                    document.querySelectorAll('.reject-btn').forEach(btn => {
                        btn.addEventListener('click', async () => {
                            const parent = btn.closest('.item-menu');
                            const ids = Array.from(parent.querySelectorAll('.trx-id')).map(i=>i.value);
                            const res = await Swal.fire({
                                title: 'Tolak pesanan?',
                                text: `Tolak pesanan dari ${parent.querySelector('.font-semibold')?.textContent || ''}?`,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Tolak',
                                cancelButtonText: 'Batal'
                            });
                            if (res.isConfirmed) {
                                for (const id of ids) {
                                    await fetch("{{ route('pegawai.orders.reject') }}", {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                                        body: JSON.stringify({ transaction_id: id })
                                    });
                                }
                                Swal.fire({toast:true, position:'top-end', icon:'success', title:'Pesanan ditolak', showConfirmButton:false, timer:2000});
                                fetchPending();
                            }
                        });
                    });

                    document.querySelectorAll('.complete-btn').forEach(btn => {
                        btn.addEventListener('click', async () => {
                            const parent = btn.closest('.item-menu');
                            const ids = Array.from(parent.querySelectorAll('.trx-id')).map(i=>i.value);
                            const res = await Swal.fire({
                                title: 'Tandai selesai?',
                                text: `Tandai pesanan dari ${parent.querySelector('.font-semibold')?.textContent || ''} sebagai selesai?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Selesai',
                                cancelButtonText: 'Batal'
                            });
                            if (res.isConfirmed) {
                                for (const id of ids) {
                                    await fetch("{{ route('pegawai.orders.complete') }}", {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                                        body: JSON.stringify({ transaction_id: id })
                                    });
                                }
                                Swal.fire({toast:true, position:'top-end', icon:'success', title:'Pesanan selesai', showConfirmButton:false, timer:2000});
                                fetchPending();
                            }
                        });
                    });

                    // Print handler for accepted orders
                    document.querySelectorAll('.print-order-btn').forEach(btn => {
                        btn.addEventListener('click', () => {
                            const orderCard = btn.closest('.item-menu');
                            if (!orderCard) return;
                            const printable = orderCard.querySelector('.print-content');
                            if (!printable) return;

                            const w = window.open('', '_blank');
                            const html = `
                                <html>
                                <head>
                                <title>Struk Pesanan</title>
                                <style>body{font-family: Arial, Helvetica, sans-serif; padding:20px}</style>
                                </head>
                                <body>${printable.innerHTML}</body>
                                </html>
                            `;
                            w.document.open();
                            w.document.write(html);
                            w.document.close();
                            w.focus();
                            setTimeout(() => w.print(), 300);
                        });
                    });
                })
                .catch(err => console.error('fetchPending err', err));
        }

        // initial fetch + polling
        fetchPending();
        setInterval(fetchPending, 3000);
    </script>
@endsection
