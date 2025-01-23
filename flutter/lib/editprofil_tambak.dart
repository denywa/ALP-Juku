import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

class EditProfilTambakPage extends StatefulWidget {
  const EditProfilTambakPage({super.key});

  @override
  _EditProfilTambakPageState createState() => _EditProfilTambakPageState();
}

class _EditProfilTambakPageState extends State<EditProfilTambakPage> {
  bool isEditing = false;
  String? siupFileName;
  final ImagePicker _picker = ImagePicker();
  
  final TextEditingController namaController = TextEditingController(text: 'Tambak Ikan A');
  final TextEditingController alamatController = TextEditingController(
      text: 'Universitas Ciputra Makassar CPI Sunset Quay, Kec. Mariso, Kel. Tanjung, Kota Makassar');
  final TextEditingController kontakController = TextEditingController(text: '+62 081288888888');
  final TextEditingController rekeningController = TextEditingController(text: '1234567890');
  
  Future<void> _pickImage() async {
    final XFile? image = await _picker.pickImage(source: ImageSource.gallery);
    if (image != null) {
      setState(() {
        siupFileName = image.name;  // Store only the filename
      });
    }
  }

  Widget _buildEditableField(String label, TextEditingController controller, {int? maxLines = 1}) {
    return Row(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        SizedBox(
          width: 100,
          child: Text(
            label,
            style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
          ),
        ),
        const SizedBox(width: 16),
        Expanded(
          child: isEditing
              ? TextField(
                  controller: controller,
                  maxLines: maxLines,
                  decoration: const InputDecoration(border: OutlineInputBorder()),
                )
              : Text(controller.text, style: const TextStyle(fontSize: 16)),
        ),
      ],
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Profil Bisnis'),
        surfaceTintColor: Colors.white,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  _buildEditableField('Nama Bisnis', namaController),
                  const Divider(height: 32),
                  _buildEditableField('Alamat', alamatController, maxLines: null),
                  const Divider(height: 32),
                  _buildEditableField('Kontak', kontakController),
                  const Divider(height: 32),
                  _buildEditableField('No. Rekening', rekeningController),
                  const Divider(height: 32),
                  
                  // SIUP File Section
                  Row(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      const SizedBox(
                        width: 100,
                        child: Text(
                          'SIUP',
                          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                        ),
                      ),
                      const SizedBox(width: 16),
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            if (siupFileName != null)
                              Container(
                                padding: const EdgeInsets.all(8),
                                decoration: BoxDecoration(
                                  border: Border.all(color: Colors.grey),
                                  borderRadius: BorderRadius.circular(8),
                                ),
                                child: Row(
                                  children: [
                                    const Icon(Icons.file_present),
                                    const SizedBox(width: 8),
                                    Expanded(
                                      child: Text(
                                        siupFileName!,
                                        style: const TextStyle(fontSize: 16),
                                      ),
                                    ),
                                  ],
                                ),
                              ),
                            if (isEditing)
                              Padding(
                                padding: const EdgeInsets.only(top: 8),
                                child: ElevatedButton.icon(
                                  onPressed: _pickImage,
                                  icon: const Icon(Icons.upload_file),
                                  label: const Text('Upload SIUP'),
                                ),
                              ),
                          ],
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
                    // Save changes logic here
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