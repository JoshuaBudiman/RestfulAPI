part of 'pages.dart';

class SendEmail extends StatefulWidget {
  const SendEmail({super.key});

  @override
  State<SendEmail> createState() => _SendEmailState();
}

class _SendEmailState extends State<SendEmail> {
  @override
  void initState() {
    super.initState();
  }

  final _loginKey = GlobalKey<FormState>();
  final ctrlEmail = TextEditingController();

  @override
  void dispose() {
    ctrlEmail.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Send Email"),
        centerTitle: true,
      ),
      body: Container(
        padding: EdgeInsets.all(24),
        child: Form(
            key: _loginKey,
            
            child: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
              TextFormField(
                keyboardType: TextInputType.emailAddress,
                decoration: InputDecoration(
                  labelText: "Email",
                  prefixIcon: Icon(Icons.email),
                ),
                controller: ctrlEmail,
                autovalidateMode: AutovalidateMode.onUserInteraction,
                validator: ((value) {
                  return !EmailValidator.validate(value.toString())
                      ? 'Email tidak valid'
                      : null;
                }),
              ),
              
            ])),
      ),
      floatingActionButton: FloatingActionButton(
                onPressed: () async {
                  if (_loginKey.currentState!.validate()) {
                    await RajaOngkirService.sendEmail(ctrlEmail.text).then((value) {
                      var result = json.decode(value.body);
                      Fluttertoast.showToast(
                        msg: result['message'].toString(),
                        toastLength: Toast.LENGTH_SHORT,
                        fontSize: 14,
                        backgroundColor: Colors.greenAccent,
                        textColor: Colors.white);
                    },);
                    
                  } else {
                    Fluttertoast.showToast(
                        msg: "Email anda tidak valid!",
                        toastLength: Toast.LENGTH_SHORT,
                        fontSize: 14,
                        backgroundColor: Colors.redAccent,
                        textColor: Colors.white);
                  }
                },
                child: const Icon(Icons.send),
              )
    );
  }
}
