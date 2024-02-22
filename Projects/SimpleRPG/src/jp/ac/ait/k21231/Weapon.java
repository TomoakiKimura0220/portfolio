package jp.ac.ait.k21231;

public class Weapon extends Equipment {
    //フィールド（追加）
    private int atk; // - 攻撃力加算値
    //コンストラクタ
    public Weapon(String name, int atk) {
        super(name);
        this.atk = atk;
    }

    public Weapon() {
        super("武器");
        this.atk = 0;
    }

    //public int getAtk() - 攻撃力加算値を返す
    public int getAtk() {
        return this.atk;
    }

    //public void setAtk(int atk) - 攻撃力加算値を設定する
    public void setAtk(int atk) {
        this.atk = atk;
    }
}
