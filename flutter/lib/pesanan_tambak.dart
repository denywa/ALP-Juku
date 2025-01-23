import 'package:flutter/material.dart';
import 'detail_pesanan_tambak.dart';

class PesananTambakPage extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Pesanan Tambak'),
      ),
      body: PesananList(),
    );
  }
}

class PesananList extends StatefulWidget {
  @override
  _PesananListState createState() => _PesananListState();
}

class _PesananListState extends State<PesananList> {
  final List<Map<String, dynamic>> orders = [
    {
      'orderId': '#12',
      'date': '18 Jan 2024',
      'estimate': '0 jam 30 Menit',
      'status': 'Dalam Pengiriman',
      'statusColor': Colors.blue[100],
      'fish': 'Nila hitam',
      'pond': 'Tambak ikan A',
      'quantity': '2 pc',
      'price': 'Rp42.000',
    },
    {
      'orderId': '#9',
      'date': '18 Jan 2024',
      'estimate': '1 jam 20 Menit',
      'status': 'Sedang Dikemas',
      'statusColor': Colors.orange[100],
      'fish': 'Nila hitam',
      'pond': 'Tambak ikan A',
      'quantity': '4 pc',
      'price': 'Rp84.000',
    },
    {
      'orderId': '#112',
      'date': '18 Jan 2024',
      'estimate': '0 Menit',
      'status': 'Sudah di Destinasi',
      'statusColor': Colors.green[100],
      'fish': 'Nila hitam',
      'pond': 'Tambak ikan A',
      'quantity': '1 pc',
      'price': 'Rp21.000',
    },
  ];

  void updateOrderStatus(int index, String newStatus, Color newColor) {
    setState(() {
      orders[index]['status'] = newStatus;
      orders[index]['statusColor'] = newColor;
    });
  }

  void showStatusPopup(BuildContext context, int index) {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          title: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text('Update Status'),
              IconButton(
                icon: Icon(Icons.close),
                onPressed: () {
                  Navigator.of(context).pop();
                },
              ),
            ],
          ),
          content: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              ListTile(
                leading: Icon(Icons.local_shipping, color: Colors.blue),
                title: Text('Dalam Pengiriman'),
                onTap: () {
                  updateOrderStatus(
                      index, 'Dalam Pengiriman', Colors.blue[100]!);
                  Navigator.of(context).pop();
                },
              ),
              ListTile(
                leading: Icon(Icons.inventory, color: Colors.orange),
                title: Text('Sedang Dikemas'),
                onTap: () {
                  updateOrderStatus(
                      index, 'Sedang Dikemas', Colors.orange[100]!);
                  Navigator.of(context).pop();
                },
              ),
              ListTile(
                leading: Icon(Icons.location_on, color: Colors.green),
                title: Text('Sudah di Destinasi'),
                onTap: () {
                  updateOrderStatus(
                      index, 'Sudah di Destinasi', Colors.green[100]!);
                  Navigator.of(context).pop();
                },
              ),
            ],
          ),
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return ListView.builder(
      padding: EdgeInsets.all(16),
      itemCount: orders.length,
      itemBuilder: (context, index) {
        final order = orders[index];
        return Card(
          elevation: 4,
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(12),
          ),
          child: Padding(
            padding: const EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      'Pesanan ${order['orderId']}',
                      style: TextStyle(fontWeight: FontWeight.bold),
                    ),
                    PopupMenuButton<String>(
                      onSelected: (String value) {
                        if (value == 'Detail') {
                          Navigator.push(
                            context,
                            MaterialPageRoute(
                              builder: (context) => DetailPesananTambakPage(),
                            ),
                          );
                        } else if (value == 'Status') {
                          showStatusPopup(context, index);
                        }
                      },
                      itemBuilder: (BuildContext context) {
                        return [
                          PopupMenuItem(
                            value: 'Detail',
                            child: Text('Detail'),
                          ),
                          PopupMenuItem(
                            value: 'Status',
                            child: Text('Status'),
                          ),
                        ];
                      },
                    ),
                  ],
                ),
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Text(
                      order['date'],
                      style: TextStyle(color: Colors.grey),
                    ),
                    Text(
                      'Estimasi: ${order['estimate']}',
                      style: TextStyle(color: Colors.grey),
                    ),
                  ],
                ),
                SizedBox(height: 8),
                Row(
                  children: [
                    Image.asset(
                      'assets/nilahitam.png',
                      height: 64,
                      width: 64,
                    ),
                    SizedBox(width: 16),
                    Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            order['fish'],
                            style: TextStyle(
                                fontSize: 18, fontWeight: FontWeight.bold),
                          ),
                          SizedBox(height: 4),
                          Text(order['quantity']),
                        ],
                      ),
                    ),
                    Text(
                      order['price'],
                      style:
                          TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
                    ),
                  ],
                ),
                Align(
                  alignment: Alignment.bottomRight,
                  child: Container(
                    padding: EdgeInsets.symmetric(horizontal: 12, vertical: 4),
                    decoration: BoxDecoration(
                      color: order['statusColor'],
                      borderRadius: BorderRadius.circular(12),
                    ),
                    child: Text(
                      order['status'],
                      style: TextStyle(fontWeight: FontWeight.bold),
                    ),
                  ),
                ),
              ],
            ),
          ),
        );
      },
    );
  }
}

void main() {
  runApp(MaterialApp(
    home: PesananTambakPage(),
  ));
}
