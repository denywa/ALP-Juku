import 'package:flutter/material.dart';

class EditProfilTambakPage extends StatefulWidget {
  const EditProfilTambakPage({super.key});

  @override
  _EditProfilTambakPageState createState() => _EditProfilTambakPageState();
}

class _EditProfilTambakPageState extends State<EditProfilTambakPage> {
  bool isEditing = false;
  final TextEditingController alamatController = TextEditingController(text: 'Universitas Ciputra Makassar CPI Sunset Quay, Kec. Mariso, Kel. Tanjung, Kota Makassar');
  final TextEditingController kontakController = TextEditingController(text: '+62 081288888888');
  final TextEditingController deskripsiController = TextEditingController(text: 'Tambak ikan yang menjual ikan segar, terutama ikan bolu. Untuk pertanyaan lebih lanjut bisa chat lewat kontak');

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profil Toko'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Profile Section
            Row(
              children: [
                const CircleAvatar(
                  radius: 40,
                  child: Icon(
                    Icons.person,
                    size: 40,
                  ),
                ),
                const SizedBox(width: 16),
                const Text(
                  'Tambak Ikan A',
                  style: TextStyle(
                    fontSize: 20,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ],
            ),
            const SizedBox(height: 20),

            // Address Section
            Container(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const SizedBox(
                        width: 80,
                        child: Text(
                          'Alamat',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                      const SizedBox(width: 16),
                      Expanded(
                        child: isEditing
                            ? TextField(
                                controller: alamatController,
                                maxLines: null,
                                decoration: const InputDecoration(
                                  border: OutlineInputBorder(),
                                ),
                              )
                            : Text(
                                alamatController.text,
                                style: const TextStyle(fontSize: 16),
                              ),
                      ),
                    ],
                  ),
                  const Divider(height: 32),

                  // Contact Section
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const SizedBox(
                        width: 80,
                        child: Text(
                          'Kontak',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                      const SizedBox(width: 16),
                      Expanded(
                        child: isEditing
                            ? TextField(
                                controller: kontakController,
                                decoration: const InputDecoration(
                                  border: OutlineInputBorder(),
                                ),
                              )
                            : Text(
                                kontakController.text,
                                style: const TextStyle(fontSize: 16),
                              ),
                      ),
                    ],
                  ),
                  const Divider(height: 32),

                  // Description Section
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const SizedBox(
                        width: 80,
                        child: Text(
                          'Deskripsi',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                      const SizedBox(width: 16),
                      Expanded(
                        child: isEditing
                            ? TextField(
                                controller: deskripsiController,
                                maxLines: null,
                                decoration: const InputDecoration(
                                  border: OutlineInputBorder(),
                                ),
                              )
                            : Text(
                                deskripsiController.text,
                                style: const TextStyle(fontSize: 16),
                              ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
      floatingActionButton: isEditing
          ? Row(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                FloatingActionButton(
                  onPressed: () {
                    setState(() {
                      isEditing = false;
                    });
                  },
                  backgroundColor: Colors.red,
                  child: const Icon(Icons.close),
                ),
                const SizedBox(width: 16),
                FloatingActionButton(
                  onPressed: () {
                    setState(() {
                      isEditing = false;
                    });
                    // Simpan perubahan logic
                  },
                  backgroundColor: Colors.blue,
                  child: const Icon(Icons.save),
                ),
              ],
            )
          : FloatingActionButton(
              onPressed: () {
                setState(() {
                  isEditing = true;
                });
              },
              child: const Icon(Icons.edit),
            ),
    );
  }
}
