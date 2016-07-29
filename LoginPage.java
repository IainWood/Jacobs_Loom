package loginpage;

//Imports
import java.io.BufferedReader;
import javafx.event.ActionEvent;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Application;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Label;
import javafx.scene.control.PasswordField;
import javafx.stage.Stage;
import org.jasypt.encryption.pbe.StandardPBEStringEncryptor;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;
import javafx.scene.image.Image;
import javafx.scene.layout.Pane;
import javafx.scene.shape.Line;

/**
 * @author Iain Woodburn
 */
public class LoginPage extends Application {
    
    //For building the windows
    private Parent root;
    private Scene scene;
    private static Stage primaryStage;
    private FXMLLoader loader;
    
    //FXML fx:id
    @FXML private Label welcome_message;
    @FXML private TextField username_field;
    @FXML private PasswordField password_field1;
    @FXML private Label errorLogin;
    @FXML private Label errorLabel;
    @FXML private PasswordField password_field2;
    @FXML private Label balanceAmount;
    @FXML private Label name;
    @FXML private Label email;
    @FXML private Label phone;
    @FXML private Label street1;
    @FXML private Label street2;
    @FXML private Label city_state_zip;
    @FXML private Line line;
    @FXML private Pane deposit_pane;
    @FXML private Pane pickup_pane;
    @FXML private TextField amountToDeposit;
    @FXML private TextField confirmAmount;
    @FXML private Button makeDeposit;
    @FXML private Button pickupButton;
    @FXML private Label errorLabelDeposit;
    
    //For mySQL
    Connection myConn;
    Statement myStatement;
    ResultSet myRs;
    private static final String URL = "jdbc:mysql://localhost:3306/new_schema";
    private static final String USERNAME = "root";
    private static final String PASSWORD = "J@c0bsl0om";
    
    private static String track1 = "";
    private static String track2 = "";
    private static String track3 = "";
    
    /**
     * Starts the program, and opens the first window
     * @param primaryStage - first window 
     */
    @Override
    public void start(Stage primaryStage) {
        
        try {
            LoginPage.primaryStage = primaryStage;
            loader = new FXMLLoader(getClass().getResource("Login.fxml"));
            loader.load();
            
            root = FXMLLoader.load(getClass().getResource("Login.fxml"));
            scene = new Scene(root);
            primaryStage.setTitle("Login");
            primaryStage.setScene(scene);
            primaryStage.getIcons().add(new Image(getClass().getResourceAsStream("images/jacobsloomicon.png")));
            primaryStage.show();
        } catch (IOException ex) {
            Logger.getLogger(getClass().getName()).log(Level.SEVERE, null, ex);
        }

    }
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        launch(args);
    }
    
    /**
     * Gets a connection to the database
     */
    private void getConnectionToDB(){
        
        try {
            myConn = DriverManager.getConnection(URL, USERNAME , PASSWORD);
            //Creates a statement
            myStatement = myConn.createStatement();
        } catch (SQLException ex) {
            Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    } //end getConnectionToDB
    
    /**
     * Fills the labels with information from the database
     * @param evt - When the Load Info button is clicked
     */
    @FXML
    public void fillInfo(ActionEvent evt){
        String emp_id = "'".concat("1".concat("'"));
        String emp_first_name = "";
        String emp_last_name = "";
        String emp_balance = "";
        String emp_email = "";
        String emp_phone = "";
        String emp_street_address1 = "";
        String emp_street_address2 = "";
        String emp_city = "";
        String emp_state = "";
        String emp_zip = "";
        
        try {
            //Makes the buttons, lines, ect. appear
            setElementsVisible();
            
            //Opens a connection with the database
            getConnectionToDB();
            
            //Gets specific username from database
            myRs = myStatement.executeQuery("SELECT * FROM employees WHERE emp_id=" + emp_id);
            
            //Retrieves the information of the given user
            while(myRs.next()){
                emp_first_name = myRs.getString("emp_first_name");
                emp_last_name = myRs.getString("emp_last_name");
                emp_balance = myRs.getString("emp_balance");
                emp_email = myRs.getString("emp_email");
                emp_phone = myRs.getString("emp_phone");
                emp_street_address1 = myRs.getString("emp_street_address1");
                emp_street_address2 = myRs.getString("emp_street_address2");
                emp_city = myRs.getString("emp_city");
                emp_state = myRs.getString("emp_state");
                emp_zip = myRs.getString("emp_zip");
            }
            
            name.setText(emp_first_name + " " + emp_last_name);
            balanceAmount.setText("Current Balance: " + emp_balance);
            email.setText("Email: " + emp_email);
            phone.setText("Phone: " + emp_phone);
            street1.setText("Address: " + emp_street_address1);
            street2.setText(emp_street_address2);
            city_state_zip.setText(emp_city + " " + emp_state + " " + emp_zip);
            
        } catch (SQLException ex) {
            Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
        }
        
    }
    
    /**
     * Makes the buttons, lines, et. visible
     */
    private void setElementsVisible(){
        line.setVisible(true);
        makeDeposit.setVisible(true);
        pickupButton.setVisible(true);
    }
    
    /**
     * Makes the deposit pane visible
     * @param evt - When the Deposit button is clicked
     */
    @FXML
    public void makeDeposit(ActionEvent evt){
        deposit_pane.setVisible(true);
    }
    
    /**
     * Makes the pickup pane visible
     * @param evt - When the Pickup button is clicked
     */
    @FXML
    public void makePickup(ActionEvent evt){
        pickup_pane.setVisible(true);
    }
    
    /**
     * Makes all of the panels invisible
     * @param evt - When cancel is clicked on any panel
     */
    @FXML
    public void cancel(ActionEvent evt){
        deposit_pane.setVisible(false);
        pickup_pane.setVisible(false);
    }
    
    /**
     * Changes the users balance
     * @param evt - When the deposit button is clicked
     */
    @FXML
    public void deposit(ActionEvent evt){
        String amount = amountToDeposit.getText();
        String confirm = confirmAmount.getText();
        
        if(!amount.equals(confirm)){
            errorLabelDeposit.setText("The amounts do not match!");
        } else {
            
        }
        
    }
    
    /**
     * Quits the program
     * @param evt - When the close button, or close menu option is clicked
     */
    @FXML
    public void close(ActionEvent evt){
        System.exit(0);
    }
    
    /**
     * Encrypts a string, using seed keyword "password"
     * @param rawString - Un-encrypted data
     * @return the encrypted string
     */
    private String encrypt(String rawString){
        
        String seed = "password";
        
        StandardPBEStringEncryptor encryptor = new StandardPBEStringEncryptor();
        encryptor.setPassword(seed);
        return encryptor.encrypt(rawString);
    }
    
    /**
     * Decrypts the string AFTER is is read from the file by the method 'readFromFile'
     * @param encryptedString
     * @return decrypted string
     */
    private String decrypt(String encryptedString){
        //Seed must be same as what was used to encrypt origially
        String seed = "password";
        
        StandardPBEStringEncryptor decryptor = new StandardPBEStringEncryptor();
        decryptor.setPassword(seed);
        
        //Decrypts and returns the raw string
        return decryptor.decrypt(encryptedString);
    }
    
    /**
     * Writes the employee's information to a file
     * @param text - the actual info, raw and unparsed
     * @param filepath - path to the file being written to
     * @param filename - name of file being written to
     * @return true if writing is successful, false otherwise
     */
    private boolean writeToFile(String text, String filepath, String filename){
        
        try { 
          //Creates new file, even if one already exists, good for security
          FileWriter fWriter = new FileWriter(filepath.concat(filename)); 
            try (BufferedWriter writer = new BufferedWriter(fWriter)) {
                writer.write(text);
                writer.newLine();
            }

        } catch (Exception e) {
            toggleError("Error reading card, please try again");
        }
        
        return false;
        
    }
    
    /**
     * Reads the employee's card
     * activated when card is slid however, possible explanation is 
     * hidden return character on end of mag stripe
     * @param evt - click of the Read Card button, is automatically
     */
    @FXML
    public void readCardButton(ActionEvent evt){

        try {
            String filePath = "C:\\Users\\Marcus Woodburn\\Documents\\";
            String fileName = "employeeCardInfo.txt";
            
            //Gets the string from the password box
            String password = password_field2.getText();
            
            //Acts as a test to see if text is valid,
            //if not, this displays the error and does
            //not allow the form to close
            if(!validateInput(password)){
                toggleError("Error reading card, please try again");
            }
            
            //Encrypts string directly after it is collected and BEFORE it is passed or written to the file
            password = encrypt(password);
            writeToFile(password , filePath , fileName);
            
            //Seperates the information into three tracks
            parseTracks(readFromFile());
            System.out.println("Track 1: " + track1);
            System.out.println("Track 2: " + track2);
            System.out.println("Track 3: " + track3);
            
            //Closes the window
            //primaryStage.close();

            //Opens the third window, Employee Information
            root = FXMLLoader.load(getClass().getResource("EmployeeInfo.fxml"));
            scene = new Scene(root);
            primaryStage.setTitle("Employee Information");
            primaryStage.setScene(scene);
            primaryStage.show();
            System.out.println(root);
            System.out.println(scene);
            System.out.println(primaryStage);
        } catch (IOException ex) {
            Logger.getLogger(LoginPage.class.getName()).log(Level.SEVERE, null, ex);
        }
            
    }   
    
    /**
     * Makes an error message appear if the input is invalid
     * 
     * @param errMessage - the error message to be displayed
     */
    public void toggleError(String errMessage){
        errorLabel.setText(errMessage);
        errorLabel.setVisible(true);
    }
    
    /**
     * Tests if the input is valid
     * @param rawData
     * @return true if input contains three '?' false otherwise
     */
    private boolean validateInput(String rawData){
        int numOfQuestionMarks = 0;
        
        for(int i = 0; i < rawData.length(); i++){
                if(rawData.charAt(i) == '?'){
                    numOfQuestionMarks++;
                }

        } //end for 
        return numOfQuestionMarks == 3;
    } //end validateInput
    
    /**
     * Reads the employee's card info from the file
     * @return employee card information, not parsed
     */
    @SuppressWarnings("null")
    private String readFromFile(){
        //Gets the username of the computer for the file path
        String computerName = System.getProperty("user.name");
        BufferedReader reader = null;
        String filePath = "";
        String fileName = "";
        
        try{
            //Use concat for error handeling
            filePath = "C:\\Users\\".concat(computerName).concat("\\Documents\\");
            fileName = "employeeCardInfo.txt";
        }catch (NullPointerException e){
            toggleError("Error reading card, please try again");
        }

        try {
            
            File file = new File(filePath.concat(fileName));
            reader = new BufferedReader(new FileReader(file));

            String nextLineinFile;
            while ((nextLineinFile = reader.readLine()) != null) {
                    nextLineinFile = decrypt(nextLineinFile); //Decrypts the line into the raw information
                   return nextLineinFile;
            }

        } catch (IOException e) {
            toggleError("Error reading card, please try again");
        } finally {
            try {
                reader.close();
            } catch (IOException | NullPointerException e) {
                toggleError("Error reading card, please try again");
            }
        }
        //Default, this should never be executed
        return "";
    }
    
    /**
     * Parses the information found in the card, after
     * it is decrypted. The format for the raw data is as follows
     * %track1?;track2?+track3?
     * @param rawData the data, decrypted, from readFromFile()
     */
    private void parseTracks(String rawData){
        //rawData = %track1?;track2?+track3?   total:
        //          012345678901234567890123   23  
        
        if(rawData != null && !rawData.isEmpty()){
            
            int numOfQuestionMarks = 0;
            
            for(int i = 0; i < rawData.length(); i++){
                    if(rawData.charAt(i) == '?'){
                        numOfQuestionMarks++;
                    }

            } //end for
            
            if(numOfQuestionMarks == 3){
            
                try{

                    int beginT1 = 1;
                    int endT1 = -1;

                    for(int i = 0; i < rawData.length(); i++){
                           
                        if(rawData.charAt(i) == '?'){
                            endT1 = i;
                            break;
                        }

                    }

                    track1 = rawData.substring(beginT1 , endT1);

                    int beginT2 = 1;
                    int endT2 = -1;

                    rawData = rawData.substring(endT1+1);

                    for(int i = 0; i < rawData.length(); i++){

                        if(rawData.charAt(i) == '?'){
                            endT2 = i;
                            break;
                        }

                    }

                    track2 = rawData.substring(beginT2 , endT2);

                    int beginT3 = 1;
                    int endT3 = -1;

                    rawData = rawData.substring(endT2+1);

                    for(int i = 0; i < rawData.length(); i++){

                        if(rawData.charAt(i) == '?'){
                            endT3 = i;
                            break;
                        }

                    }

                    track3 = rawData.substring(beginT3 , endT3);

                }catch (Exception e){
                    toggleError("Error reading card, please try again");
                } //end try-catch
            
            }else{
                toggleError("Error reading card, please try again");
            }
            
        } //end if
        
    } //end parseTracks
    
    /**
     * Handles the event of logging into the application
     * @param evt - When the login button is clicked
     */
    @SuppressWarnings({"CallToPrintStackTrace", "UseSpecificCatch"})
    @FXML
    public void loginButton(ActionEvent evt){
        
        try{
            //Gets the string from the username box and password box 
            String username = username_field.getText();
            String password = password_field1.getText();
            
            //Password found in the database
            String dbPassword = "";
            
            //Formats the username so that it can be used in the mySQL statement
            username = "'".concat(username.concat("'"));
            
            //Opens connection with the database
            getConnectionToDB();
            
            //Gets specific username from database
            myRs = myStatement.executeQuery("SELECT * FROM employees WHERE emp_username=" + username);
            
            while(myRs.next()){
                //Gets the password stored inside the database
                dbPassword = myRs.getString("emp_password"); //hashed password
            }
            
            //Verifies hashed password with the one provided, using BCrypt
            if(BCrypt.checkpw(password , dbPassword)){
                //If password is correct, and username is found, then sets the window to the card reader
                root = FXMLLoader.load(getClass().getResource("CardReader.fxml"));
                scene = new Scene(root);
                primaryStage.setTitle("Card Reader");
                primaryStage.setScene(scene);
                primaryStage.show();
                System.out.println(root);
                System.out.println(scene);
                System.out.println(primaryStage);
            } else {
                errorLogin.setText("Username or password was incorrect");
            }
            
        }catch (Exception e){
            errorLogin.setText("Username or password was incorrect");
            e.printStackTrace();
        }
        
    } //end loginButton
    
} //end class
